<?php

namespace App\Controller;

use App\Entity\Post as Post;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/api/posts", name="Comments controller api") */
class PostController extends AbstractController
{
    #[Route('/post', name: 'post')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PostController.php',
        ]);
    }

    /**
     * @Route("/getAll", name="list of all posts", methods={"GET"})
     * @return Response
     */
    public function listOfAllPosts(PostRepository $repo): Response
    {

        $data = Post::MapDataToPostDataProjection($repo->findAll());

        return new JsonResponse($data, Response::HTTP_OK);

    }
}
