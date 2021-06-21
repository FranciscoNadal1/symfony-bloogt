<?php


namespace App\Controller\Main;


use App\Entity\Chat;
use App\Entity\Post;
use App\Entity\User as User;
use App\Form\UserCreationForm;
use App\Repository\CategoryRepository;
use App\Repository\ChatRepository;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\PostService;
use App\Services\UserService;
use App\Services\Utils;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserController extends AbstractController
{

    public function getUserProfile(Request $request, UserService $userService, Utils $utils, string $username)
    {
        $_SESSION['uri'] = $request->getRequestUri();

//        $UserData = $userRepo->findOneBy(array('username' => $username));

        $UserData = $userService->getUserByUsername($username);
        return $this->render('main/routes/userProfile.html.twig', array(
            'User' => $UserData,
            'UtilsCommonVars' => $utils->getVars()
        ));

    }



    public function getUserProfilePosts(Request $request, UserService $userService, Utils $utils, PostService $postService, string $username)
    {

        $_SESSION['uri'] = $request->getRequestUri();

        $UserData = $userService->getUserByUsername($username);


       // $postData = $postRepo->findBy(array('createdBy' => $UserData), array('createdAt' => 'DESC'));
        $postData = $postService->getAllPostsCreatedBy($UserData);

        return $this->render('main/routes/subRoutes/userProfilePosts.html.twig', array(
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


    public function getUserProfileComments(Request $request, UserService $userService, UserRepository $userRepo, Utils $utils, CommentsRepository $commentRepo, string $username)
    {
        $_SESSION['uri'] = $request->getRequestUri();

        //   $UserData = $userRepo->findOneBy(array('username' => $username));
        $UserData = $userService->getUserByUsername($username);

        $commentData = $commentRepo->findBy(array('createdBy' => $UserData), array('createdAt' => 'DESC'));

        return $this->render('main/routes/subRoutes/userProfileComments.html.twig', array(
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

        return $this->render('main/routes/userCreation.html.twig', [
            'postCreation' => $postForm->createView(),
            'UtilsCommonVars' => $utils->getVars()
        ]);
    }




    public function successUser(Utils $utils)
    {

        return $this->render('main/successUserCreated.html.twig', array(
            'UtilsCommonVars' => $utils->getVars()
        ));

    }


    public function accountIndex(PostService $postService, UserService $userService, UserInterface $user)
    {
        $UserData = $userService->getUserByUsername($user->getUsername());

        $postData = $postService->getAllPostsFollowedBy($UserData);
            return $this->render('main/routes/account/accountAportations.html.twig', array(
                'Posts' =>$postData
            ));
    }
/*
    public function accountUser(PostService $postService, UserService $userService, UserInterface $user)
    {


        $UserData = $userService->getUserByUsername($user->getUsername());

        $usersFollowing = $UserData->getFollowing();

        $postData = $usersFollowing[3]->getPosts();

        return $this->render('main/routes/account/accountIndex.html.twig', array(
            'Posts' =>$postData

        ));

    }
*/
    public function accountUserAportations(PostService $postService, UserService $userService, UserInterface $user)
    {

        $UserData = $userService->getUserByUsername($user->getUsername());
        $postData = $postService->getAllPostsCreatedBy($UserData);



        return $this->render('main/routes/account/accountAportations.html.twig', array(
            'Posts' =>$postData

        ));

    }

    public function accountNetwork(Request $request, PostService $postService, UserService $userService, UserInterface $user)
    {
        $_SESSION['uri'] = $request->getRequestUri();

        $UserData = $userService->getUserByUsername($user->getUsername());
        $postData = $postService->getAllPostsCreatedBy($UserData);

        return $this->render('main/routes/account/accountNetwork.html.twig', array(
            'Posts' =>$postData,
            'User' =>$UserData

        ));

    }


    public function accountSendMessage(Request $request, PostService $postService, UserService $userService, UserInterface $user)
    {
        $_SESSION['uri'] = $request->getRequestUri();

        return $this->render('main/routes/account/sendMessage.html.twig', array(
        ));

    }
    public function accountSendMessageTo(string $username, Request $request, PostService $postService, UserService $userService, UserInterface $user)
    {
        $_SESSION['uri'] = $request->getRequestUri();

        return $this->render('main/routes/account/sendMessage.html.twig', array(
            'to' => $username
        ));

    }

    public function chatList(Request $request, PostService $postService, UserService $userService, ChatRepository $chatRepo, UserInterface $user)
    {
        $_SESSION['uri'] = $request->getRequestUri();

        $chatList = $chatRepo->findAll();

        return $this->render('main/routes/account/chatList.html.twig', array(
            'chatList' => $chatList
        ));

    }

    public function createChat(Request $request, PostService $postService, UserService $userService, UserInterface $user, ChatRepository $chatRepo)
    {


        $message = $_REQUEST['message'];
        $toUsername = $_REQUEST['username'];
        $User1Data = $userService->getUserByUsername($user->getUsername());
        $User2Data = $userService->getUserByUsername($toUsername);

        $chatRepo->newChat($User1Data, $message, $User2Data);

        return $this->redirect($_SESSION['uri']);

    }




    public function accountEdit(Request $request, PostService $postService, UserService $userService, UserInterface $user)
    {
        $_SESSION['uri'] = $request->getRequestUri();

        $UserData = $userService->getUserByUsername($user->getUsername());
        $postData = $postService->getAllPostsCreatedBy($UserData);

        return $this->render('main/routes/account/accountEdit.html.twig', array(
            'User' =>$UserData
        ));
    }


    public function accountEditForm(Request $request, PostService $postService, UserService $userService, UserInterface $user, UserPasswordEncoderInterface $encoder)
    {

        /** @var User|null $user */
        $UserData = $userService->getUserByUsername($user->getUsername());

/////////   Verifications first
        if (isset($_POST['email']) & $_POST['email'] != null) {

            /** @var User|null $user */
            $userOfMail = $userService->getUserByEmail($_POST['email']);

            if($userOfMail == null)
                $UserData->setEmail($_POST['email']);
            else{
                $this->addFlash('error', 'Email already exists');
                return $this->redirect($_SESSION['uri']);
            }
        }


/////////   Password verification
        if (isset($_POST['oldPassword']) & $_POST['oldPassword'] != null) {
            if (isset($_POST['newPassword']) & $_POST['newPassword'] != null){
                if (isset($_POST['repeatNewPassword']) & $_POST['repeatNewPassword'] != null){
                    if($_POST['repeatNewPassword'] != $_POST['newPassword']){
                        $this->addFlash('error', 'Passwords do not coincide');
                        return $this->redirect($_SESSION['uri']);
                    }else{
                        if($encoder->isPasswordValid( $user, $_POST['oldPassword'])){

                            ////                Valid
                            $this->addFlash('success', 'Password changed');

                            $encoded = $encoder->encodePassword($user, $_POST['repeatNewPassword']);
                            $UserData->setPassword($encoded);

                        }else{
                            $this->addFlash('error', 'Your password is not valid');
                            return $this->redirect($_SESSION['uri']);

                        }

                    }

                }
            }
        }else{
            if (isset($_POST['newPassword']) & $_POST['newPassword'] != null && isset($_POST['repeatNewPassword']) & $_POST['repeatNewPassword'] != null){
                $this->addFlash('error', 'You need to define the old password');
                return $this->redirect($_SESSION['uri']);
            }
        }




        if (isset($_POST['name']) & $_POST['name'] != null)
            $UserData->setName($_POST['name']);

        if (isset($_POST['surname']) & $_POST['surname'] != null)
            $UserData->setSurname($_POST['surname']);


        if(isset($_POST['bio']) & $_POST['bio'] != null)
            $UserData->setBio($_POST['bio']);

        if(isset($_POST['avatar']) & $_POST['avatar'] != null)
            $UserData->setAvatar($_POST['avatar']);




        $userService->createUser($UserData);

        $this->addFlash('success', 'User data was edited');

        return $this->redirect($_SESSION['uri']);
    }

    public function followUser(UserInterface $user, UserService $userService, string $username)
    {

        $userService->userFollowUser($user->getUsername(), $username);
        $this->addFlash('success', 'you followed ' . $username);

        return $this->redirect($_SESSION['uri']);
    }


    public function unfollowUser(UserInterface $user, UserService $userService, string $username)
    {


        $userService->userUnfollowUser($user->getUsername(), $username);
        $this->addFlash('success', 'You unfollowed ' . $username);

        return $this->redirect($_SESSION['uri']);


    }


}