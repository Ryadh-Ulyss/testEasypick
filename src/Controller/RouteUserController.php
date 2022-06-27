<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RouteUserController extends AbstractController
{
    public function __construct(UserRepository $userRepository)
    {
        
    }

    public function __invoke(): int
    {
        $repo = $this->entityManager->getRepository(User::class);
        $user = $repo->findOneBy(['id' => $this->getUser()]);
       
        return $user;
    }
}