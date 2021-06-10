<?php

namespace App\Controller\Main;

use App\Entity\Category;
use App\Entity\User as User;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class AdminController extends AbstractController
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

    public function getAllCategories(CategoryRepository $categoryRepo)
    {
        $category = $categoryRepo->findAll();

        return $this->render('adminTables/categoriesList.html.twig', array(
            'categories' => $category
        ));
    }

    public function newCategory(CategoryRepository $categoryRepo)
    {
        $categoryName = $_GET["category"];

        $categoryRepo->newCategory($categoryName);

        $category = $categoryRepo->findAll();
        return $this->render('adminTables/categoriesList.html.twig', array(
            'categories' => $category
        ));
    }

    public function deleteCategory(CategoryRepository $categoryRepo)
    {
        $categoryId = $_GET["id"];


        $category = $categoryRepo->findOneBy(array('id' => $categoryId));

        if($category != null)
            $categoryRepo->deleteCategoryById($categoryId);

        $categories = $categoryRepo->findAll();
        return $this->render('adminTables/categoriesList.html.twig', array(
            'categories' => $categories
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
