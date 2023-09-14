<?php

namespace App\Service\Question;

use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;

class QuestionService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Video $video
     * @return Video|object|null
     */
    public function getQuestionByVideo(Video $video): Video|null
    {
        return $this->entityManager->getRepository(Video::class)->findOneBy(['id'=>$video]);
    }
}