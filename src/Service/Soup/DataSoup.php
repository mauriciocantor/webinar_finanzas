<?php

namespace App\Service\Soup;

use App\Entity\AlphabetSoup;
use App\Repository\AlphabetSoupRepository;
use Doctrine\ORM\EntityManagerInterface;

class DataSoup
{
    private AlphabetSoup $soup;
    private EntityManagerInterface $entityManager;

    /**
     * @var array|string[]
     */
    private array $alphabet = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

    private array $soupInfo=[];
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param AlphabetSoup $soup
     * @return array
     */
    public function getSoupInfo(AlphabetSoup $soup): array
    {
        $this->soupInfo = [];
        $this->soup = $soup;

        for( $i=0; $i<= $this->soup->getRows(); $i++){
            $this->soupInfo[$i] = [];
            for ($j=0; $j<=$this->soup->getColumnSoup(); $j++){
                $randomWord = rand(0, count($this->alphabet)-1);
                $word       = $this->alphabet[$randomWord];
                $this->soupInfo[$i][$j] = $word;
            }
        }
        $words = $this->soup->getWords()??[];
        for($i=0; $i< count($words) ; $i++){
            $this->setWordToSoup(strtoupper($words[$i]));// con Mayuscula
        }

        $traps = $this->soup->getTraps()??[];
        for ($t=0;$t<count($traps);$t++){
            $this->setWordToSoup(strtoupper($traps[$i]));// con Mayuscula
        }

        return $this->soupInfo;
    }

    /**
     * @param string $word
     * @return array
     */
    function setWordToSoup(string $word): array
    {

        $form     = $this->getForm();
        $direction = $form[0];
        $orientation   = $form[1];

        $coordinated = $this->getCoordinated($form,$word);
        $x = $coordinated[0];
        $y = $coordinated[1];


        switch ($direction){
            case 'H'://-
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $c++, $z++){
                        $this->soupInfo[$f][$c] = $word[$z];
                    }
                }//DIRECTO
                if ($orientation == 'I'){
                    $y = $y + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $c--, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//INDIRECTO
                break;
            case 'V'://|
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $f++, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//DIRECTO
                if ($orientation == 'I'){
                    $x = $x + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $f--, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//INDIRECTO
                break;
            case 'I'://\
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $c++, $f++, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//DIRECTO
                if ($orientation == 'I'){
                    $x = $x + strlen($word) - 1;
                    $y = $y + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $c--, $f--, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//INDIRECTO
                break;
            case 'D':///
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $c++, $f--, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//DIRECTO
                if ($orientation == 'I'){
                    $x = $x - strlen($word) + 1;
                    $y = $y + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0; $z<(strlen($word)); $c--, $f++, $z++)
                        $this->soupInfo[$f][$c] = $word[$z];
                }//INDIRECTO
                break;
        }//switch
        return $this->soupInfo;
    }//meterPalabras

    /**
     * @param $word
     * @param $coordinates
     * @param $direction
     * @param $orientation
     * @return bool
     */
    function isFree($word, $coordinates, $direction, $orientation): bool
    {
        $x = $coordinates[0];
        $y = $coordinates[1];
        $continue = TRUE;
        switch ($direction){
            case 'H'://-
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $c++, $z++){
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                    }
                }//DIRECTO
                if ($orientation == 'I'){
                    $y = $y + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $c--, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//INDIRECTO
                break;
            case 'V'://|
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $f++, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//DIRECTO
                if ($orientation == 'I'){
                    $x = $x + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $f--, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//INDIRECTO
                break;
            case 'I'://\
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $c++, $f++, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//DIRECTO
                if ($orientation == 'I'){
                    $x = $x + strlen($word) - 1;
                    $y = $y + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $c--, $f--, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//INDIRECTO
                break;
            case 'D':///
                if ($orientation == 'D'){
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $c++, $f--, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//DIRECTO
                if ($orientation == 'I'){
                    $x = $x - strlen($word) + 1;
                    $y = $y + strlen($word) - 1;
                    for ($f=$x, $c=$y, $z=0;($z<(strlen($word)) && $continue); $c--, $f++, $z++)
                        if ((ctype_lower($this->soupInfo[$f][$c]))) $continue = FALSE;
                }//INDIRECTO
                break;
        }//switch
        return $continue;
    }

    /**
     * @param array $form
     * @param string $word
     * @return array
     */
    function getCoordinated(array $form, string $word): array
    {

        $longitude  = strlen($word);
        $direction = $form[0];
        $orientation   = $form[1];


        $dimensionX = $this->soup->getRows();
        $dimensionY = $this->soup->getColumnSoup();


        $continueProcess = TRUE;
        while ($continueProcess){
            $x = rand(0,$dimensionX-1);//echo $x;
            $y = rand(0,$dimensionY-1);//echo $y;
            $coordinates = array($x,$y);

            switch ($direction){
                case 'H'://-
                    if ((($y+$longitude)<$dimensionY) && ($this->isFree($word,$coordinates,$direction,$orientation))) $continueProcess = FALSE;
                    break;
                case 'V'://|
                    if ((($x+$longitude)<$dimensionX) && ($this->isFree($word,$coordinates,$direction,$orientation))) $continueProcess = FALSE;
                    break;
                case 'I'://\
                    if (((($x+$longitude-1)<($dimensionX)) && (($y+$longitude-1)<($dimensionY))) && ($this->isFree($word,$coordinates,$direction,$orientation))) $continueProcess = FALSE;
                    break;
                case 'D':///
                    if (((($x-$longitude+1)>=0) && (($y+$longitude-1)<$dimensionY)) && ($this->isFree($word,$coordinates,$direction,$orientation))) $continueProcess = FALSE;
                    break;
            }//switch
        }//while
        return array($x,$y);
    }

    /**
     * @return string[]
     */
    public function getForm(): array
    {

        $directions = array('H', 'V', 'I', 'D');  /*   - | / \    */
        $orientations = array('D', 'I');

        $dirRandom = rand(0, 3);
        $sentRandom = rand(0, 1);

        $direction = $directions[$dirRandom];
        $orientation = $orientations[$sentRandom];

        return array($direction, $orientation);
    }



}