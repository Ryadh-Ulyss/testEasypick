<?php

namespace App\Controller;

use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/admin", name="home")
     */
    public function index(UserRepository $userRepository, CompanyRepository $companyRepository): Response
    {

        return $this->render('home/index.html.twig', [
            'users' => $userRepository->findAll(),
            'companies' => $companyRepository->findAll()
        ]);
    }
}
