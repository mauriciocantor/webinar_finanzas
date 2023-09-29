<?php

namespace App\Controller;

use App\Entity\AlphabetSoup;
use App\Service\Soup\HandleSoup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\SwitchUserToken;

class AlphabetSoupController extends AbstractController
{
    private Security $security;
    private HandleSoup $handleSoup;

    public function __construct(Security $security, HandleSoup $handleSoup)
    {
        $this->security = $security;
        $this->handleSoup = $handleSoup;
    }

    #[Route('/alphabet/soup/{alphabetSoup}', name: 'app_alphabet_soup', methods: ['POST'])]
    public function index(Request $request, AlphabetSoup $alphabetSoup): Response
    {
        $dataResult = $request->request->all();
        $dataResult['user']=$this->security->getUser();
        $dataResult['alphabetSoup']=$alphabetSoup;
        $this->handleSoup->saveAlphabet($dataResult);

        return $this->json(['msg'=>'correct']);
    }
}
