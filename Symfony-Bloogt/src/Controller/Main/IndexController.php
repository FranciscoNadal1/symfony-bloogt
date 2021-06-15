<?php

namespace App\Controller\Main;

use App\Entity\Post as Post;
use App\Entity\User as User;
use App\Form\PostCreationForm;
use App\Form\UserCreationForm;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\PostReactionRepository;
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

    public function getUserProfilePosts(UserRepository $userRepo, CategoryRepository $categoryRepo, PostRepository $postRepo, string $username)
    {

        $UserData = $userRepo->findOneBy(array('username' => $username));
        $categoryData = $categoryRepo->findAll();


        $postData = $postRepo->findBy(array('createdBy' => $UserData), array('createdAt' => 'DESC'));

        return $this->render('main/userProfilePosts.html.twig', array(
            'User' => $UserData,
            'Categories' => $categoryData,
            'Posts' =>$postData
        ));

    }

    public function deletePost(PostRepository $postRepo, UserInterface $user)
    {
        $postId = $_GET["id"];


        $post = $postRepo->findOneBy(array('id' => $postId));

        if($post != null and $user == $post->getCreatedBy() or (in_array("ROLE_ADMIN", $user->getRoles()) or in_array("ROLE_MODERATOR",$user->getRoles())))
            $postRepo->deletePostById($postId);

        $this->addFlash('success', 'The post was deleted');
        return $this->redirectToRoute('index');
    }

    public function sendComment(PostRepository $postRepo,CommentsRepository $commentsRepo, UserInterface $user, string $id)
    {
        $commentcontent = $_POST["commentContent"];
        $post = $postRepo->findOneBy(array('id' => $id));


        if($commentsRepo->createNew($commentcontent, $post, $user) == true){

            $this->addFlash('success', 'The comment was published');
            return $this->redirectToRoute('postById', array('id' => $id));
        }
        else{

            $this->addFlash('success', 'The comment wasn\'t published');
            return $this->redirectToRoute('postById', array('id' => $id));
        }

//        $post = $postRepo->findOneBy(array('id' => $postId));

/*
        if($post != null and $user == $post->getCreatedBy() or (in_array("ROLE_ADMIN", $user->getRoles()) or in_array("ROLE_MODERATOR",$user->getRoles())))
            $postRepo->deletePostById($postId);
*/
    }


    public function getUserProfileComments(UserRepository $userRepo, CommentsRepository $commentRepo, CategoryRepository $categoryRepo, string $username)
    {

        $UserData = $userRepo->findOneBy(array('username' => $username));
        $categoryData = $categoryRepo->findAll();

        $commentData = $commentRepo->findBy(array('createdBy' => $UserData), array('createdAt' => 'DESC'));

        return $this->render('main/userProfileComments.html.twig', array(
            'User' => $UserData,
            'Categories' => $categoryData,
            'Comments' => $commentData
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

    public function votePost(UserRepository $userRepo, PostRepository $postRepo, PostReactionRepository $postReactionRepo, UserInterface $user, int $postId, string $reaction)
    {



        $userData = $userRepo->findOneBy(array('username' => $user->getUsername()));
        $postData = $postRepo->findOneBy(array('id' => $postId));



        $reactionFromDatabase = null;
    if($userData->getReactionOfUserOfPost($postData) != null)
        $reactionFromDatabase = $userData->getReactionOfUserOfPost($postData)->isReaction();


  //      $this->addFlash('success', $reactionFromDatabase . $reaction);
     //   return $this->redirectToRoute('postById', array('id' => $postId));
/*
        if($reactionFromDatabase != null and $reactionFromDatabase != $reaction){

            $this->addFlash('success', 'Es distinto!!!');
            return $this->redirectToRoute('postById', array('id' => $postId));
        }
*/


        if($reaction == "true")
            $reactBool = true;
        else
            $reactBool = false;

        $postReactionRepo->newPostReaction($postData, $reactBool, $user);


        $this->addFlash('success', 'You voted this post successfully');
        return $this->redirectToRoute('postById', array('id' => $postId));
    }

    public function successUser(CategoryRepository $categoryRepo)
    {

        $categoryData = $categoryRepo->findAll();
        return $this->render('main/successUserCreated.html.twig', array(
            'Categories' => $categoryData
        ));

    }
}
