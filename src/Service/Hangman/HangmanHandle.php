<?php

namespace App\Service\Hangman;

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

}