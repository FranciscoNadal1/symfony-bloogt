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
use App\Services\PostService;
use App\Services\UserService;
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



    public function sendComment(PostService $postService, CommentsRepository $commentsRepo, UserInterface $user, string $id)
    {
        $commentcontent = $_POST["commentContent"];
        //$post = $postRepo->findOneBy(array('id' => $id));
        $post = $postService->getPostById($id);

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





}
