<?php


namespace App\Controller\Main;


use App\Entity\Post as Post;
use App\Form\PostCreationForm;
use App\Repository\CategoryRepository;
use App\Repository\CommentReactionRepository;
use App\Repository\CommentsRepository;
use App\Repository\PostReactionRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\PostService;
use App\Services\UserService;
use App\Services\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class PostController extends AbstractController
{


    public function getAllPosts(Request $request, PostRepository $postRepo, Utils $utils)
    {

        $_SESSION['uri'] = $request->getRequestUri();
        $postData = $postRepo->findBy(array(), array('createdAt' => 'DESC'));
        return $this->render('main/routes/postList.html.twig', array(
            'Posts' => $postData,
            'UtilsCommonVars' => $utils->getVars()
        ));

    }


    public function getAllPostsByRandom(Request $request, PostService $postService, Utils $utils)
    {

        $_SESSION['uri'] = $request->getRequestUri();
       // $postData = $postRepo->findBy(array(), array());
        $postData = $postService->getAllPosts();
        shuffle($postData);

        return $this->render('main/routes/postList.html.twig', array(
            'Posts' => $postData,
            'UtilsCommonVars' => $utils->getVars()
        ));

    }


    public function getPostById(Request $request, PostService $postService, Utils $utils, int $id)
    {

        $_SESSION['uri'] = $request->getRequestUri();

       // $postData = $postRepo->findOneBy(array('id' => $id));
        $postData = $postService->getPostById($id);

        return $this->render('main/routes/postDetails.html.twig', array(
            'post' => $postData,
            'UtilsCommonVars' => $utils->getVars()
        ));

    }


    public function deletePost(PostService $postService, UserInterface $user, Utils $utils)
    {
        $postId = $_GET["id"];


      //  $post = $postRepo->findOneBy(array('id' => $postId));
        $post = $postService->getPostById($postId);

        if($post != null and $user == $post->getCreatedBy() or (in_array("ROLE_ADMIN", $user->getRoles()) or in_array("ROLE_MODERATOR",$user->getRoles())))
            $postService->deletePostById($postId);
           // $postRepo->deletePostById($postId);

        $this->addFlash('success', 'The post was deleted');
        return $this->redirectToRoute('index');
    }


    public function getAllPostsOfCategory(Request $request, string $category, PostService $postService, Utils $utils)
    {
/*
        $categoryObject = $categoryRepo->findOneBy(array('name' => $category));
        $postData = $postRepo->findBy(array('category' => $categoryObject), array('createdAt' => 'DESC'));
*/
        $_SESSION['uri'] = $request->getRequestUri();
        $postData = $postService->getAllPostsOfCategory($category);



        return $this->render('main/routes/postList.html.twig', array(
            'Posts' => $postData,
            'Category' => $category,
            'UtilsCommonVars' => $utils->getVars()
        ));

    }

    public function getAllPostsOfFollowedUsers(Request $request, PostService $postService, Utils $utils, UserInterface $user, UserService $userService)
    {

        $_SESSION['uri'] = $request->getRequestUri();
    //    $postData = $postService->getAllPostsOfCategory($category);

        $UserData = $userService->getUserByUsername($user->getUsername());
        $postData = $postService->getAllPostsFollowedBy($UserData);


        return $this->render('main/routes/postList.html.twig', array(
            'Posts' => $postData,
            'Category' => "followed users",
            'UtilsCommonVars' => $utils->getVars()
        ));

    }

    public function postCreation(Request $request, CategoryRepository $categoryRepo, PostRepository $postRepo, UserInterface $user, Utils $utils): Response
    {
        $post = new Post();
        $postForm = $this->createForm(PostCreationForm::class, $post);
        $postForm->handleRequest($request);


        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $data = $postForm->getData();
            $title = $data->getTitle();
            $content = $data->getContent();
            $category = $categoryRepo->findOneBy(array('name' => 'QuickPost'));

            $postRepo->createNew($content, $category, $user);

            $this->addFlash('success', 'The post is created successfully');


            return $this->redirectToRoute('index');
            /*
            return $this->render('main/successPostCreated.html.twig', [
                'content' => $content,
                'categoryName' => $category->getName(),
                'UtilsCommonVars' => $utils->getVars()
            ]);
*/
//            return $this->redirectToRoute('index');
        }

        return $this->render('main/routes/postCreation.html.twig', [
            'postCreation' => $postForm->createView(),
            'UtilsCommonVars' => $utils->getVars()
        ]);
    }

    public function successPost(CategoryRepository $categoryRepo, Utils $utils)
    {

        return $this->render('main/successPostCreated.html.twig', array(
            'UtilsCommonVars' => $utils->getVars()
        ));

    }

    public function votePost(UserRepository $userRepo, Utils $utils, PostRepository $postRepo, PostReactionRepository $postReactionRepo, UserInterface $user, int $postId, string $reaction)
    {

        if(isset($_SESSION['uri']))
            $uri = $_SESSION['uri'];

        $userData = $userRepo->findOneBy(array('username' => $user->getUsername()));
        $postData = $postRepo->findOneBy(array('id' => $postId));


        $postReaction = $postReactionRepo->findBy(array('post' => $postData, 'reactedBy' => $userData));

        foreach($postReaction as $unitReaction){
            $postReactionRepo->remove($unitReaction);
        }

        $this->addFlash('error', 'You voted this post successfully');


        if($reaction == "true")
            $reactBool = true;
        else
            $reactBool = false;

        $postReactionRepo->newPostReaction($postData, $reactBool, $user);

        return $this->redirect($uri);
    }

    public function voteComment(Request $request, UserRepository $userRepo, Utils $utils, PostRepository $postRepo, CommentsRepository $commentRepo, CommentReactionRepository $commentReactionRepo, UserInterface $user, int $commentId, string $reaction)
    {
        if(isset($_SESSION['uri']))
            $uri = $_SESSION['uri'];

        $userData = $userRepo->findOneBy(array('username' => $user->getUsername()));
        $commentData = $commentRepo->findOneBy(array('id' => $commentId));


        $commentReaction = $commentReactionRepo->findBy(array('comment' => $commentData, 'reactedBy' => $userData));

        foreach($commentReaction as $unitReaction){
            $commentReactionRepo->remove($unitReaction);
        }

        $this->addFlash('error', 'You voted this comment successfully');


        if($reaction == "true")
            $reactBool = true;
        else
            $reactBool = false;

        $commentReactionRepo->newCommentReaction($commentData, $reactBool, $user);

       // return $this->redirectToRoute($uri);
        return $this->redirect($uri);
    }
}