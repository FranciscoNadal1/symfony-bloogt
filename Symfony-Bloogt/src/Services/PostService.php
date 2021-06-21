<?php


namespace App\Services;


use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\PersistentCollection;
use Faker\Factory;

class PostService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PostRepository  */
    private $postRepository;

    /** @var CategoryRepository  */
    private $categoryRepository;

    /** @var UserService  */
    private $userService;


    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository, CategoryRepository $categoryRepository, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userService = $userService;
    }



    public function createUPost(Post $post): void
    {
        $this->postRepository->create($post);
    }

    public function deletePost(Post $post): void
    {
        $this->postRepository->remove($post);
    }

    public function deletePostById(int $postId): void
    {
        $post = $this->postRepository->find($postId);
        $this->postRepository->remove($post);
    }

    public function getPostById(int $id): ?Post
    {
        /** @var Post|null $post */
        $post = $this->postRepository->find($id);
        if (is_null($post)) {
            return null;
        }

        return $post;
    }

    public function getMoreVotedPostLastHour()
    {

        /** @var Post|null $post */
        $post = $this->postRepository->getBestPostLastHour();

        if (is_null($post)) {
            return null;
        }

        return $post;
    }

    public function getAllPosts()
    {
        /** @var Post|null $post */
        $post = $this->postRepository->findAll();
        if (is_null($post)) {
            return null;
        }

        return $post;
    }

    public function getAllPostsCreatedBy(User $user)
    {
        /** @var PersistentCollection|Post|null $post */
        $post = $this->postRepository->findBy(array('createdBy' => $user), array('createdAt' => 'DESC'));

        return $post;
    }

    public function getAllPostsFollowedBy(User $user)
    {

        $usersFollowing = $user->getFollowing();

        $postData = array();
        foreach($usersFollowing as $userFollowed){
            $postData = array_merge($postData, $userFollowed->getPosts()->getValues());
        }
        return $postData;
    }

    public function getAllPostsOfCategory($categoryName)
    {
        /** @var Post|null $post */
        $categoryObject = $this->categoryRepository->findOneBy(array('name' => $categoryName));
        $posts = $this->postRepository->findBy(array('category' => $categoryObject), array('createdAt' => 'DESC'));

        if (is_null($posts)) {
            return null;
        }

        return $posts;
    }


    public function createRandomPost(){
        $faker = Factory::create();

        $categoryAll = $this->categoryRepository->findAll();
        $allUsers = $this->userService->getAllUsers();

        shuffle($categoryAll);
        shuffle($allUsers);

        /** @var Category|null $categoryRandom */
        $categoryRandom = $categoryAll[0];

        /** @var User|null $user */
        $user = $allUsers[0];

        /** @var Post|null $post */
        $post = new Post();

        $post->setCategory($categoryRandom);

      //  $content = "a";
     //   $content = $faker->sentence(13);
        $content = $faker->realText(500,5);
        $post->setContent($content);

        $post->setCreatedBy($user);


        $this->createUPost($post);

    }
}