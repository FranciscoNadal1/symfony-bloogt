<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\User as User;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }


    /**
     * @Route("/user/addBaseUsers", name="user", methods={"GET"})
     */
    public function addBaseUsers(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setUsername("admin");
        $user->setPassword("123456");
        $user->setEmail("admin@admin.es");
        $user->setName("admin");
        $user->setSurname("OfThis");

        $user->setAvatar("OfThis");
        $user->setBackground("OfThis");


        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
            'userId' => $user->getId(),
        ]);
    }
}
