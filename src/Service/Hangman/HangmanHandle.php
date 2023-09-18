<?php

namespace App\Service\Hangman;

use App\Entity\HangmanResult;
use Doctrine\ORM\EntityManagerInterface;

class HangmanHandle
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $result
     * @return void
     */
    public function saveResult(array $result): void
    {
        $hangmanResult = new HangmanResult();
        $hangmanResult->setResultDate(new \DateTime());
        $hangmanResult->setUser($result['user']);
        $hangmanResult->setVideo($result['video']);
        $hangmanResult->setText($result['text']);
        $hangmanResult->setIsCorrect(($result['result'] === 'true'));

        $this->entityManager->persist($hangmanResult);
        $this->entityManager->flush($hangmanResult);
    }
}