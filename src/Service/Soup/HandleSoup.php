<?php

namespace App\Service\Soup;

use App\Entity\AlphabetSoup;
use App\Entity\AlphabetSoupResult;
use Doctrine\ORM\EntityManagerInterface;

class HandleSoup
{
    private DataSoup $soup;
    private EntityManagerInterface $entityManager;

    public function __construct(DataSoup $soup, EntityManagerInterface $entityManager)
    {
        $this->soup = $soup;
        $this->entityManager = $entityManager;
    }

    /**
     * @param AlphabetSoup $alphabetSoup
     * @return array
     */
    public function getAlphabetSoup(AlphabetSoup $alphabetSoup): array
    {
        return $this->soup->getSoupInfo($alphabetSoup);
    }

    public function saveAlphabet(array $datos): void
    {
        $alphabetSoup = new AlphabetSoupResult();
        $alphabetSoup->setAlphabetSoup($datos['alphabetSoup']);
        $alphabetSoup->setUser($datos['user']);
        $alphabetSoup->setIsCorrect(($datos['isCorrect']==='true'));
        $alphabetSoup->setLive($datos['live']);
        $alphabetSoup->setFoundWord($datos['foundWord']);
        $alphabetSoup->setDateResult(new \DateTime());

        $this->entityManager->persist($alphabetSoup);
        $this->entityManager->flush($alphabetSoup);
    }

}
