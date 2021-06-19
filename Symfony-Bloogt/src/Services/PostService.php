<?php


namespace App\Services;


use App\Entity\Post;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class PostService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var PostRepository  */
    private $postRepository;

    /** @var CategoryRepository  */
    private $categoryRepository;



    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
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
      //  $query = $this->postRepository->getEntityManager()->createQuery('SELECT post.* FROM .reaction, .post, .category where reaction.dtype = \'postreaction\' and reaction.reaction = true	and reaction.created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR) 	and post.id = reaction.post_id	and post.category_id = category.id	group by reaction.post_id order by count(*) desc  limit 0, 1 ');


        /** @var Post|null $post */
     //   $post = $query->getResult();

        $post = $this->postRepository->getBestPostLastHour();

        // $query = $em->createQuery('SELECT post.* FROM .reaction, .post, .category where reaction.dtype = \'postreaction\' and reaction.reaction = true	and reaction.created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR) 	and post.id = reaction.post_id	and post.category_id = category.id	group by reaction.post_id order by count(*) desc');

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
}