<?php

namespace App\Controller\Main;

use App\Entity\Post as Post;
use App\Entity\User as User;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class IndexController extends AbstractController
{
    public function getAllPosts(PostRepository $postRepo, CategoryRepository $categoryRepo)
    {

        $postData = $postRepo->findBy(array(), array('createdAt' => 'DESC'));
        $categoryData = $categoryRepo->findAll();
        return $this->render('main/postList.html.twig', array(
            'Posts' => $postData,
            'Categories' => $categoryData,
        ));

    }

    public function getPostById(PostRepository $postRepo, CategoryRepository $categoryRepo, int $id)
    {

        $postData = $postRepo->findOneBy(array('id' => $id));
        $categoryData = $categoryRepo->findAll();
        return $this->render('main/postDetails.html.twig', array(
            'post' => $postData,
            'Categories' => $categoryData,
        ));

    }
    public function getUserProfile(UserRepository $userRepo, CategoryRepository $categoryRepo, string $username)
    {

        $UserData = $userRepo->findOneBy(array('username' => $username));
        $categoryData = $categoryRepo->findAll();
        return $this->render('main/userProfile.html.twig', array(
            'User' => $UserData,
            'Categories' => $categoryData,
        ));

    }

    public function getAllPostsOfCategory(string $category, PostRepository $postRepo, CategoryRepository $categoryRepo)
    {

        $categoryObject = $categoryRepo->findOneBy(array('name' => $category));
        $postData = $postRepo->findBy(array('category' => $categoryObject), array('createdAt' => 'DESC'));
        $categoryData = $categoryRepo->findAll();
        return $this->render('main/postList.html.twig', array(
            'Posts' => $postData,
            'Categories' => $categoryData,
            'Category' => $category
        ));

    }

}
