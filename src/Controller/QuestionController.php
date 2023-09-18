<?php

namespace App\Controller;

use App\Entity\Video;
use App\Service\Question\QuestionService;
use App\Service\Soup\HandleSoup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private QuestionService $questionService;
    private HandleSoup $handleSoup;

    /**
     * @param QuestionService $questionService
     */
    public function __construct(
        QuestionService $questionService,
        HandleSoup $handleSoup
    )
    {

        $this->questionService = $questionService;
        $this->handleSoup = $handleSoup;
    }

    #[Route('/question/{video}', name: 'app_question')]
    public function index(Video $video): Response
    {
        $alphabetSoup=null;
        $alphabetSoupFromVideo = $video->getAlphabetSoups()->first();
        if($alphabetSoupFromVideo) {
            $alphabetSoup = $this->handleSoup->getAlphabetSoup($alphabetSoupFromVideo);
        }
        $video = $this->questionService->getQuestionByVideo($video);
        return $this->render('question/index.html.twig', [
            'video' => $video,
            'alphabetSoup' => $alphabetSoup,
            'alphabetSoupFromVideo'=>$alphabetSoupFromVideo
        ]);
    }

    #[Route('/question/new', name: 'save')]
    public function save(Request $request){


    }
}
