<?php

namespace App\Service\Soup;

use App\Entity\AlphabetSoup;

class HandleSoup
{
    private DataSoup $soup;

    public function __construct(DataSoup $soup)
    {
        $this->soup = $soup;
    }

    /**
     * @param AlphabetSoup $alphabetSoup
     * @return array
     */
    public function getAlphabetSoup(AlphabetSoup $alphabetSoup): array
    {
        return $this->soup->getSoupInfo($alphabetSoup);
    }

}
