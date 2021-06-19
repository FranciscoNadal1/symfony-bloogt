<?php


namespace App\Services;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Services\PostService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityManager;

class Utils extends ServiceEntityRepository
{

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PostRepository  */
    private $postRepository;

    /** @var PostService\  */
    private $postService;

    /** @var CategoryRepository  */
    private $categoryRepository;


    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository, CategoryRepository $categoryRepository, PostService $postService)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->postService = $postService;
        $this->categoryRepository = $categoryRepository;
    }

    public function getVars(){

        $categoryData = $this->categoryRepository->findAll();
        $post = $this->postService->getMoreVotedPostLastHour();

        $array = array(
            'BestPostLastHour' => $post,
            'Categories' => $categoryData
        );


        return $array;
    }
}