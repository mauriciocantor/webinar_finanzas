<?php

namespace App\Controller;

use App\Entity\Video;
use App\Service\Question\QuestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private QuestionService $questionService;

    /**
     * @param QuestionService $questionService
     */
    public function __construct(QuestionService $questionService)
    {

        $this->questionService = $questionService;
    }

    #[Route('/question/{video}', name: 'app_question')]
    public function index(Video $video): Response
    {
        $video = $this->questionService->getQuestionByVideo($video);
        return $this->render('question/index.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/question/new', name: 'save')]
    public function save(Request $request){


    }
}
