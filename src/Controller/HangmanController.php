<?php

namespace App\Controller;

use App\Entity\Video;
use App\Service\Hangman\HangmanHandle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\SwitchUserToken;

class HangmanController extends AbstractController
{
    private HangmanHandle $hangmanHandle;
    private Security $security;

    public function __construct(HangmanHandle $hangmanHandle, Security $security)
    {
        $this->hangmanHandle = $hangmanHandle;
        $this->security = $security;
    }

    #[Route('/hangman/{video}', name: 'app_hangman', methods: ['POST'])]
    public function index(Request $request, Video $video): Response
    {
        $dataResult = $request->request->all();
        $dataResult['user']=$this->security->getUser();
        $dataResult['video']=$video;
        $this->hangmanHandle->saveResult($dataResult);
        return $this->json(['msg'=>'finish']);
    }
}
