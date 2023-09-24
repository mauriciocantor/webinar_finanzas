<?php

namespace App\Controller;

use App\Entity\ModuleVideo;
use App\Entity\Video;
use App\Service\Video\SaveVideo;
use App\Service\Video\VideoServices;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    private Security $security;
    private VideoServices $videoServices;
    private SaveVideo $saveVideo;

    /**
     * @param Security $security
     * @param VideoServices $videoServices
     * @param SaveVideo $saveVideo
     */
    public function __construct(
        Security $security,
        VideoServices $videoServices,
        SaveVideo $saveVideo
    )
    {

        $this->security = $security;
        $this->videoServices = $videoServices;
        $this->saveVideo = $saveVideo;
    }
    #[Route('/video', name: 'app_video')]
    public function index(): Response
    {
        $videos = $this->videoServices->getVideosByRole(
            $this->security->getUser()->getRoles()
        );

        //$videos = $this->videoServices->getTestPassed($videos,$this->security->getUser());

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

        $validation=array_filter($videos, function (ModuleVideo $module) use ($video){
            return in_array($video,$module->getVideos()->toArray());
        });

        if(count($validation)<=0){
            return $this->redirectToRoute('_preview_error',["code"=>403]);
        }

       /* $indexItem = array_search($video, $videos, true);
        $playList = [
            'before'=> $videos[$indexItem-1] ?? null,
            'after'=> $videos[$indexItem+1] ?? null,
        ];*/

        $videos = $this->videoServices->getRoleFromTestAvailable($videos, $this->security->getUser()->getRoles());

        $videoUser = $this->saveVideo->getVideoByUser($this->security->getUser(),$video);
        return $this->render('video/learning.html.twig',[
            'video'     => $video,
            'videoUser' => $videoUser,
            'withTest' => (count($videos)>0),
//            'playList' => $playList
        ]);
    }

    #[Route('/save_video', name: 'app_video_save_video_by_user', methods: ['POST'])]
    public function saveVideoByUser(Request $request): \Symfony\Component\HttpFoundation\JsonResponse
    {
        try {
            $datos = $request->request->all();
            $video = $datos['data']['video'];

            $this->saveVideo->saveVideoByUser($video);
            $result = true;
        }catch (\Exception $exception){
            $result = false;
        }

        return $this->json([
            'result'=>$result
        ]);
    }
}
