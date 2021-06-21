<?php

namespace App\Tests;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use mysql_xdevapi\Exception;
use PHPUnit\Framework\TestCase;

class UserTestOld extends TestCase
{

    private $userRepositoryMock;
    private $userMock;
    private $mockedEm;

    protected function setUp() : void
    {
        $this->userRepositoryMock = $this->createMock(UserRepository::class);
        $this->userMock = $this->createMock(User::class);
        $this->mockedEm = $this->createMock(EntityManager::class);



    }


    protected function tearDown() : void
    {
        $this->userRepositoryMock = null;
        $this->userMock = null;
    }

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////        AUXILIAR METHODS



    public function createUser(): User
    {

        fwrite(STDOUT, __METHOD__ . "\n");
        // $userRepo = new UserRepository();
        $userRepo = $this->createMock(UserRepository::class);
   //     $userRepo->
       // $userRepo = new UserRepository(new User);
        //$userRepo = UserRepository::class;


        //   $this->assertTrue(true);
        $username = "test002";
        $password = "test002";
        $name = "name";
        $surname = "surname";
        $email = $username."@testMail.es";
        $bio = "randomBio";

/*
        $userRepo->expects(User)
            ->method('findBy')
            ->will($this->returnValue(null));
*/

        return $this->userRepositoryMock->newUser($username, $password, $name, $surname, $email, $bio);
    }
/*
    public function deleteTestUser(User $user): bool
    {


        if($userRepositoryMock->remove($user)){
            return true;
        }
        return false;
    }
*/
    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////        TEST FUNCTIONS
    ///
    /**
     * @group UserManipulation
     */
    public function aaaaatestUserCreationNew(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");

        $user = new User();

        $username = "TestUser101";
        $password = "TestPassword101";
        $name = "TestName";
        $surname = "TestSurName";
        $email = $username."@"."testMail.es";
        $bio = "Test Bio";

        $user->setUsername($username);
        $user->setPassword($password);
        $user->setName($name);
        $user->setSurname($surname);
        $user->setEmail("aaaaaaaaaaaaaaaaaa");
        $user->setBio($bio);

        $entityManager = $this->mockedEm;
        $entityManager->persist($user);
        $entityManager->flush();

        $roles = new Role($user, "ROLE_USER");

        $entityManager = $this->mockedEm;
        $entityManager->persist($roles);
        $entityManager->flush();

        $user->setRoles($roles);

        //return $this->em->getManager('User')->find

         //   $userFetched = $this->mockedEm->getRepository(User::class)->findOneBy(array('username' => $username));
            $userFetched = $this->mockedEm->getRepository(User)->findAll(array());
            print_r($userFetched);

        $this->assertNotNull($userFetched, "User entity generated is null");
        $this->assertInstanceOf(User::class, $userFetched, "User could not be created");
    }
    /**
     * @group UserManipulation
     */
    public function aaaaaaatestUserCreation(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
        $user = $this->createUser();
        /*
        $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->will($this->returnValue(<value>));

*/


        $this->assertInstanceOf(User::class, $user, "User could not be created");
    }

    /**
     * @group UserManipulation
     */
    public function ddddtestUserDeletion(): void
    {

     //   $userRepo = $this->createMock(UserRepository::class);

        $user = $this->userRepositoryMock
            ->expects($this->once())
            ->method('findOneBy')
            ->willReturn($this->userMock);



        $bool = $this->userRepositoryMock->remove($user);
        $this->assertTrue($bool, "Test user could not be deleted");

    }
/*
    public function testMapUserBasicData(): void
    {
        $user = $this->createTestUser();
        $json = User::MapDataToUserBasicDataProjection($user);
        $this->assertIsArray($json, "Data could not be converted to array");
    }

    public function testMapUserData(): void
    {
        $user = $this->createTestUser();


        $json = User::MapDataToUserDataProjection($user);
        $this->assertIsArray($json, "Data could not be converted to array");
    }
*/
}
