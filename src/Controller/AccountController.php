<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Company;
use App\Repository\CompanyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class AccountController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }
    /**
     * @Route("/compte", name="account")
     */
    public function index()
    {
        $idCompany= $this->getUser()->getCompany()->getId();
        return $this->render('account/index.html.twig', [
            'idCompany' => $idCompany
        ]);
    }
}
