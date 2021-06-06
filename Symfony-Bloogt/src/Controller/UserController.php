<?php

namespace App\Controller;

use App\Repository\RoleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\UserRepository;


use App\Entity\User as User;

/** @Route("/api/user", name="User controller api") */
class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    /**
     * @Route("/getAllUsers", name="list of all users", methods={"GET"})
     * @return Response
     */
    public function listOfAllUsers(UserRepository $repo): Response
    {

    //$    $data = array();
/*
        foreach($repo->findAll() as $dat) {
            $data[] = User::UserData($dat);
        }
*/
    $data = User::MapDataToUserDataProjection($repo->findAll());


        return new JsonResponse($data, Response::HTTP_OK);

    }

    /**
     * @Route("/getUserByUsername/{username}", name="Get user by username", methods={"GET"})
     * @return Response
     */
    public function getUsernameById(UserRepository $repo, string $username): Response
    {

        $userData = $repo->findOneBy(array('username' => $username));

  //     print_r($userData->getRoles());

        if($userData == null){
            $data =[
                'message' => "No data was found",
                'status' => "500"
            ];
            return new JsonResponse($data, 500);
        }

        $data = User::MapDataToUserDataProjection($userData);



        return new JsonResponse($data, Response::HTTP_OK);

    }


    /**
     * @Route("/newUser", name="create new user", methods={"POST"})
     */
    public function newUser(Request $request, UserRepository $repo, RoleRepository $roleRepo): Response
    {


        $data = json_decode($request->getContent(), true);

        $user = new User();


        if(!isset($data['username']) || (!isset($data['email'])) || (!isset($data['password']))){

            $data =[
                'message' => "Missing parameters",
                'status' => "500"
            ];
            return new JsonResponse($data, Response::HTTP_NOT_ACCEPTABLE);

        }

        if(isset($data['username']))
            $user->setUsername($data['username']);
        if(isset($data['email']))
            $user->setEmail($data['email']);
        if(isset($data['password']))
            $user->setPassword($data['password']);


        if(isset($data['name']))
            $user->setName($data['name']);
        if(isset($data['surname']))
            $user->setSurname($data['surname']);
        if(isset($data['bio']))
            $user->setBio($data['bio']);
        if(isset($data['avatar']))
            $user->setAvatar($data['avatar']);
        if(isset($data['background']))
            $user->setBackground($data['background']);



        if($repo->save($user)){
            if($roleRepo->associateAuthorityToUser($user, "ROLE_USER")){
                return new JsonResponse(User::MapDataToUserDataProjection($user), Response::HTTP_OK);
            }
        }
//        else{
            $data =[
                'message' => "Data could not be saved on the database",
                'status' => "500"
            ];
            return new JsonResponse($data, Response::HTTP_NOT_ACCEPTABLE);
  //      }

    }
}
