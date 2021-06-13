<?php

namespace App\Controller\Main;

use App\Entity\Post as Post;
use App\Entity\User as User;
use App\Form\PostCreationForm;
use App\Form\UserCreationForm;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;


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
    public function getAllPostsByRandom(PostRepository $postRepo, CategoryRepository $categoryRepo)
    {

        $postData = $postRepo->findBy(array(), array());
        shuffle($postData);
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


    public function postCreation(Request $request, CategoryRepository $categoryRepo, PostRepository $postRepo, UserInterface $user): Response
    {
        $post = new Post();
        $postForm = $this->createForm(PostCreationForm::class, $post);
        $postForm->handleRequest($request);


        $categoryData = $categoryRepo->findAll();
        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $data = $postForm->getData();
            $title = $data->getTitle();
            $content = $data->getContent();
            $category = $categoryRepo->findOneBy(array('name' => 'QuickPost'));

            $postRepo->createNew($content, $category, $user);

            $this->addFlash('success', 'The post is created successfully');

              return $this->render('main/successPostCreated.html.twig', [
                            'content' => $content,
                            'categoryName' => $category->getName(),
                            'Categories' => $categoryData
                        ]);

            return $this->redirectToRoute('index');
        }

        return $this->render('main/postCreation.html.twig', [
            'postCreation' => $postForm->createView(),
            'Categories' => $categoryData
        ]);
    }
    public function userCreation(Request $request, CategoryRepository $categoryRepo, UserRepository $userRepo, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $postForm = $this->createForm(UserCreationForm::class, $user);
        $postForm->handleRequest($request);


        $categoryData = $categoryRepo->findAll();
        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $data = $postForm->getData();

            $username = $data->getUsername();
            $plainPassword = $data->getPassword();

            $password = $encoder->encodePassword($user, $plainPassword);

            $name = $data->getName();
            $surname = $data->getSurname();
            $email = $data->getEmail();
            $bio = $data->getBio();


            $user = $userRepo->newUser($username, $password, $name, $surname, $email, $bio);



            $this->addFlash('success', 'The registration is successfull, you can login now');
/*
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->tokenStorage->setToken($token);

            $event = new InteractiveLoginEvent($request, $token);
            $this->eventDispatcher->dispatch(SecurityEvents::INTERACTIVE_LOGIN, $event);
*/


            return $this->redirectToRoute('login');
/*
            return $this->render('main/postList.html.twig', [
                'username' => $username,
                'Categories' => $categoryData
            ]);


            */
        }

        return $this->render('main/userCreation.html.twig', [
            'postCreation' => $postForm->createView(),
            'Categories' => $categoryData
        ]);
    }
    public function successPost(CategoryRepository $categoryRepo)
    {

       $categoryData = $categoryRepo->findAll();
        return $this->render('main/successPostCreated.html.twig', array(
            'Categories' => $categoryData
        ));

    }
    public function successUser(CategoryRepository $categoryRepo)
    {

        $categoryData = $categoryRepo->findAll();
        return $this->render('main/successUserCreated.html.twig', array(
            'Categories' => $categoryData
        ));

    }
}
