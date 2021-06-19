<?php


namespace App\Controller\Main;


use App\Entity\User as User;
use App\Form\UserCreationForm;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\UserService;
use App\Services\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{

    public function getUserProfile(UserService $userService, Utils $utils, string $username)
    {

//        $UserData = $userRepo->findOneBy(array('username' => $username));

        $UserData = $userService->getUserByUsername($username);
        return $this->render('main/userProfile.html.twig', array(
            'User' => $UserData,
            'UtilsCommonVars' => $utils->getVars()
        ));

    }



    public function getUserProfilePosts(UserService $userService, Utils $utils, PostRepository $postRepo, string $username)
    {

        $UserData = $userService->getUserByUsername($username);


        $postData = $postRepo->findBy(array('createdBy' => $UserData), array('createdAt' => 'DESC'));

        return $this->render('main/userProfilePosts.html.twig', array(
            'User' => $UserData,
            'UtilsCommonVars' => $utils->getVars(),
            'Posts' =>$postData
        ));

    }


    public function deleteUser(PostRepository $postRepo, UserService $userService, Utils $utils, UserInterface $user)
    {
        $userId = $_GET["id"];


        $fetchedUser = $userService->getUserById($userId);

        if($fetchedUser != null and $fetchedUser == $user or (in_array("ROLE_ADMIN", $user->getRoles()) or in_array("ROLE_MODERATOR",$user->getRoles())))
            $userService->deleteUser($fetchedUser);

        $this->addFlash('success', 'The user was deleted');
        return $this->redirectToRoute('index');
    }


    public function getUserProfileComments(UserService $userService, UserRepository $userRepo, Utils $utils, CommentsRepository $commentRepo, string $username)
    {

        //   $UserData = $userRepo->findOneBy(array('username' => $username));
        $UserData = $userService->getUserByUsername($username);

        $commentData = $commentRepo->findBy(array('createdBy' => $UserData), array('createdAt' => 'DESC'));

        return $this->render('main/userProfileComments.html.twig', array(
            'User' => $UserData,
            'UtilsCommonVars' => $utils->getVars(),
            'Comments' => $commentData
        ));

    }


    public function userCreation(UserService $userService, Request $request, Utils $utils, CategoryRepository $categoryRepo, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $postForm = $this->createForm(UserCreationForm::class, $user);
        $postForm->handleRequest($request);


        if ($postForm->isSubmitted() && $postForm->isValid()) {

            $data = $postForm->getData();

            $username = $data->getUsername();
            $plainPassword = $data->getPassword();

            $password = $encoder->encodePassword($user, $plainPassword);

            $name = $data->getName();
            $surname = $data->getSurname();
            $email = $data->getEmail();
            $bio = $data->getBio();


            $user = $userService->createUserWithFields($username, $password, $name, $surname, $email, $bio);




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
            'UtilsCommonVars' => $utils->getVars()
        ]);
    }




    public function successUser(CategoryRepository $categoryRepo, Utils $utils)
    {

        $categoryData = $categoryRepo->findAll();
        return $this->render('main/successUserCreated.html.twig', array(
            'Categories' => $categoryData
        ));

    }
}