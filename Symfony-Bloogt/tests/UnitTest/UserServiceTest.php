<?php


namespace App\Tests\UnitTest;

use App\Entity\User;
use App\Services\UserService;
use App\Tests\MockEntityManager;
use App\Tests\MockRepos\UserMockRepo;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private const EXPECTED_ID = 1;

    /** @var User */
    private $expectedUser;

    /** @var UserMockRepo */
    private $userRepository;

    /** @var MockEntityManager */
    private $entityManager;

    /** @var PostService */
    private $service;

    public function setUp(): void
    {
        $this->expectedUser = new User();
        $this->userRepository = new UserMockRepo($this->expectedUser, self::EXPECTED_ID);
        $this->entityManager = new MockEntityManager();
        $this->service = new UserService($this->entityManager, $this->userRepository);
    }

    public function testCreateUser(): void
    {
        fwrite(STDOUT, __METHOD__ . "\n");
    //    $user = new User();

        $username = "TestUser101";
        $password = "TestPassword101";
        $name = "TestName";
        $surname = "TestSurName";
        $email = $username."@"."testMail.es";
        $bio = "Test Bio";


        $user = $this->service->createUserWithFields($username, $password, $name, $surname, $email, $bio);

      //  print_r("id:" . $user->getCreatedAt());

        $this->assertTrue($this->entityManager->isPersisted($user));
        $this->assertTrue($this->entityManager->hasFlushed());
    }

    public function testGetUser(): void
    {

        fwrite(STDOUT, __METHOD__ . "\n");
           $user = $this->service->getUserById(self::EXPECTED_ID);
    //          $user = $this->service->getUserByUsername("TestUser101");

   //     $username = "TestUser101";

    //    $user = $this->userRepository->findOneBy(array('username' => $username));



      //  print_r("id:" . $user->getCreatedAt());
        $this->assertSame($this->expectedUser, $user);
    }


}