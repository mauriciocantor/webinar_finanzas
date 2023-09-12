<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    private Security $security;

    public function __construct(
        Security $security
    )
    {

        $this->security = $security;
    }
    #[Route('/video', name: 'app_video')]
    public function index(): Response
    {
        dump($this->security->getUser()->getRoles());die;
        return $this->render('video/index.html.twig', [
            'videos' => 'VideoController',
        ]);
    }
}
