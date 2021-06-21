<?php

namespace App\Controller\Main;

use App\Entity\Category;
use App\Entity\User as User;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use App\Services\CommentService;
use App\Services\PostService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Faker\Factory;
use Faker\Generator;


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
    public function categoryCreation(CategoryRepository $categoryRepo)
    {
        $category = $categoryRepo->findAll();

        return $this->render('adminTables/categoriesCreation.html.twig', array(
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

    public function deletePost(PostRepository $postRepo)
    {
        $postId = $_GET["id"];


        $post = $postRepo->findOneBy(array('id' => $postId));

        if($post != null)
            $postRepo->deletePostById($postId);

        $this->addFlash('success', 'The post is deleted successfully');
        return $this->redirectToRoute('listAllPosts');
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





    public function newRandomUsers(UserService $userService)
    {
        if(isset($_GET['numberOfUsers'])){

            $numberOfUsers = $_GET['numberOfUsers'];
            for($i=0;$i!=$numberOfUsers;$i++){
                $userService->createRandomUser();
            }
            $this->addFlash('success', $numberOfUsers . ' random users were created');

        }

        return $this->render('adminTables/createRandomUsers.html.twig', array(
        ));
    }


    public function newRandomPosts(PostService $postService)
    {

        if(isset($_GET['numberOfPosts'])){

            $numberOfPosts = $_GET['numberOfPosts'];
            for($i=0;$i!=$numberOfPosts;$i++){
                $postService->createRandomPost();
            }
            $this->addFlash('success', $numberOfPosts . ' random posts were created');

        }

        return $this->render('adminTables/createRandomPosts.html.twig', array(
        ));
    }

    public function newRandomComments(CommentService $commentService)
    {

        if(isset($_GET['numberOfComments'])){

            $numberOfComments = $_GET['numberOfComments'];
            for($i=0;$i!=$numberOfComments;$i++){
                $commentService->createRandomComment();
            }
            $this->addFlash('success', $numberOfComments . ' random comments were created');

        }

        return $this->render('adminTables/createRandomComments.html.twig', array(
        ));
    }
}
