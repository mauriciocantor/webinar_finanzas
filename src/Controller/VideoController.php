<?php

namespace App\Controller;

use App\Entity\Video;
use App\Service\VideoServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;

class VideoController extends AbstractController
{
    private Security $security;
    private VideoServices $videoServices;

    /**
     * @param Security $security
     * @param VideoServices $videoServices
     */
    public function __construct(
        Security $security,
        VideoServices $videoServices
    )
    {

        $this->security = $security;
        $this->videoServices = $videoServices;
    }
    #[Route('/video', name: 'app_video')]
    public function index(): Response
    {
        $videos = $this->videoServices->getVideosByRole(
            $this->security->getUser()->getRoles()
        );

        return $this->render('video/index.html.twig', [
            'videos' => $videos,
        ]);
    }

    #[Route('/learning/{video}', name: 'learning_video')]
    public function learning(Video $video): Response
    {
        $videos = $this->videoServices->getVideosByRole(
            $this->security->getUser()->getRoles()
        );
        if(!in_array($video,$videos)){
            return $this->redirectToRoute('_preview_error',["code"=>403]);
        }

        return $this->render('video/learning.html.twig',[
            'video'=>$video
        ]);
    }
}
