<?php

namespace App\Controller\RestApi;

use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Comments as Comments;

/** @Route("/api/comments", name="Comments controller api") */
class CommentsController extends AbstractController
{

    /**
     * @Route("/getAllComments", name="list of all comments", methods={"GET"})
     * @return Response
     */
    public function listOfAllComments(CommentsRepository $repo): Response
    {
        //          dump($repo->findAll());
        $data = Comments::MapDataToCommentsDataProjection($repo->findAll());

        return new JsonResponse($data, Response::HTTP_OK);

    }
}
