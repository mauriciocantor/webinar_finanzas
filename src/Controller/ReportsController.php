<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ModuleVideoRepository;
use App\Repository\UserRepository;
use App\Service\Report\Report;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reports')]
class ReportsController extends AbstractController
{
    private Security $security;
    private UserRepository $userRepository;
    private Report $report;
    private ModuleVideoRepository $moduleVideoRepository;

    public function __construct(Security $security, UserRepository $userRepository, Report $report, ModuleVideoRepository $moduleVideoRepository)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->report = $report;
        $this->moduleVideoRepository = $moduleVideoRepository;
    }

    #[Route('/', name: 'app_reports')]
    public function index(Request $request): Response
    {
        if(!in_array('ROLE_ADMIN',$this->security->getUser()->getRoles())){
            return $this->redirectToRoute('_preview_error',["code"=>403]);
        }
        $allResult = $this->moduleVideoRepository->getVideoCorrects();
        $queryBuilder = $this->userRepository->findAllQueryBuilder();
        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page',1),
            9
        );

        return $this->render('reports/index.html.twig', [
            'pager' => $pagerfanta,
            'allResult' => $allResult
        ]);
    }

    #[Route('/user/{user}', name: 'app_reports_getreportbyuser')]
    public function getReportByUser(User $user)
    {
        $writer = $this->report->getReport($user);
        $response = new StreamedResponse(
            function () use ($writer){
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="ReporteVideosCorrector'.$user->getId().'.xls"');
        $response->headers->set('Cache-Control','max-age=0');
        return $response;
    }

    #[Route('/allUser/{type}', name: 'app_reports_getreportalluser')]
    public function getReportAllUser(Request $request)
    {
        if(!in_array('ROLE_ADMIN',$this->security->getUser()->getRoles())){
            return $this->redirectToRoute('_preview_error',["code"=>403]);
        }

        if($request->get('type')=='1'){
            $writer = $this->report->getReportAlphabetSoup();
            $nameFile = 'ReporteSopaLetras.xls';
        }else{
            $writer = $this->report->getReportHangman();
            $nameFile = 'ReporteAhorcado.xls';
        }

        $response = new StreamedResponse(
            function () use ($writer){
                $writer->save('php://output');
            }
        );

        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$nameFile.'"');
        $response->headers->set('Cache-Control','max-age=0');
        return $response;
    }
}
