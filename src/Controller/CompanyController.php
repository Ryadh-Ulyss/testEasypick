<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompanyController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/inscription-entreprise", name="register_company")
     */
    public function registerCompany(Request $request): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $company = $form->getData();
           
            $this->entityManager->persist($company);
            $this->entityManager->flush();
        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
