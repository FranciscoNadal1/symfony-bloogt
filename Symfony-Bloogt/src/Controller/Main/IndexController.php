<?php

namespace App\Controller\Main;

use App\Entity\User as User;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class IndexController extends AbstractController
{
    public function getAllApiRoutes(RouterInterface $router)
    {
        $routes = $router->getRouteCollection();

        $filteredRoutes = $routes;

        $filteredRoutes = array();
        foreach($routes as $dat) {
            if(sizeof($dat->getMethods()) > 0)
                $filteredRoutes[] = $dat;
        }

        return $this->render('adminTables/routesTable.html.twig', array(
            'routes' => $filteredRoutes
        ));

    }

    public function getAllUsers(UserRepository $repo)
    {

            $users = $repo->findAll();
        return $this->render('adminTables/userList.html.twig', array(
            'users' => $users
        ));

    }


    public function getPostsOfUser(UserRepository $userRepo, string $username)
    {
        $users = $userRepo->findOneBy(array('username' => $username));

        return $this->render('adminTables/postList.html.twig', array(
            'posts' => $users->getPosts()
        ));
    }

    public function getAllPosts(PostRepository $postRepo)
    {
        $posts = $postRepo->findAll();

        return $this->render('adminTables/postList.html.twig', array(
            'posts' => $posts
        ));
    }

    public function getAllComments(CommentsRepository $commentRepo)
    {
        $comments = $commentRepo->findAll();

        return $this->render('adminTables/commentList.html.twig', array(
            'comments' => $comments
        ));
    }
    public function getCommentsOfUser(UserRepository $userRepo, string $username)
    {
        $users = $userRepo->findOneBy(array('username' => $username));

        return $this->render('adminTables/commentList.html.twig', array(
            'comments' => $users->getComments()
        ));
    }

}
