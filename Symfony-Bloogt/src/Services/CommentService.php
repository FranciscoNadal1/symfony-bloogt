<?php


namespace App\Services;


use App\Entity\Post;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;

class CommentService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PostRepository  */
    private $postRepository;

    /** @var CategoryRepository  */
    private $categoryRepository;

    /** @var CommentsRepository  */
    private $commentsRepository;

    /** @var UserService  */
    private $userService;


    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository,  CommentsRepository $commentsRepository, CategoryRepository $categoryRepository, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userService = $userService;
        $this->commentsRepository = $commentsRepository;
    }


    public function createRandomComment(){
        $faker = Factory::create();

        $postAll = $this->postRepository->findAll();
        $allUsers = $this->userService->getAllUsers();

        shuffle($postAll);
        shuffle($allUsers);

        /** @var Post|null $postRandom */
        $postRandom = $postAll[0];

        /** @var User|null $userRandom */
        $userRandom = $allUsers[0];



        $message = $faker->realText(200,5);

        $this->commentsRepository->createNew($message, $postRandom, $userRandom);
    }
}