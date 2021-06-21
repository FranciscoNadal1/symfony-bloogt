<?php


namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use mysql_xdevapi\Exception;
use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var UserRepository  */
    private $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function createUserWithFields(string $username, $password, $name, $surname, $email, $bio){

        $user = new User();

        $user->setUsername($username);
        $user->setPassword($password);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($email);
        $user->setBio($bio);

        $this->createUser($user);

        return $user;
    }


    public function createUser(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function deleteUser(User $user): void
    {
        $this->userRepository->remove($user);
    }

    public function getAllUsers()
    {

        $users = $this->userRepository->findAll();
        if (is_null($users)) {
            return null;
        }

        return $users;
    }
    public function getUserById(int $id): User
    {
        /** @var User|null $user */
        $user = $this->userRepository->find($id);
        if (is_null($user)) {
            return null;
        }

        return $user;
    }

    public function getUserByEmail(string $email): ?User
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(array('email' => $email));
        if (is_null($user)) {
            return null;
        }

        return $user;
    }

    public function getUserByUsername(string $username): ?User
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(array('username' => $username));

        if (is_null($user)) {
            return null;
        }

        return $user;
    }

    public function userFollowUser(string $username, string $userToFollowUsername): void
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(array('username' => $username));
        /** @var User|null $user */
        $userToFollow = $this->userRepository->findOneBy(array('username' => $userToFollowUsername));

        $user->getFollowing()->add($userToFollow);

        $this->userRepository->save($user);

    }

    public function userUnfollowUser(string $username, string $userToFollowUsername): void
    {
        /** @var User|null $user */
        $user = $this->userRepository->findOneBy(array('username' => $username));
        /** @var User|null $user */
        $userToFollow = $this->userRepository->findOneBy(array('username' => $userToFollowUsername));

        $user->getFollowing()->removeElement($userToFollow);

        $this->userRepository->save($user);


    }

    public function createRandomUser(){

        $faker = Factory::create();

        $username = $faker->userName;
        while($this->getUserByUsername($username) != null){
            $username = $faker->userName;
        }

        $password = $faker->password;
        $name = $faker->name;
        $surname = $faker->lastName;

        $email = $faker->email;
        while($this->getUserByEmail($email) != null){
            $email = $faker->email;
        }

        $bio = $faker->realText(200,5);
        $avatar = $faker->imageUrl(100,100,null,false);

        $user = new User();

        $user->setUsername($username);
        $user->setPassword($password);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail($email);

        $user->setBio($bio);
        $user->setAvatar($avatar);

        $this->createUser($user);

        return $user;
    }
}