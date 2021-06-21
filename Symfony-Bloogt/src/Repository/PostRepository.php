<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function search($searchText){
        //$em = $this->getEntityManager();
        $query = $this->getEntityManager()->createQuery("SELECT u FROM App\Entity\Post u where u.content like '%$searchText%' order by u.createdAt desc");
        $posts = $query->getResult();

        /*
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')
            ->from("post", 'u');
        $result=$qb->getQuery()->getResult();
        */
        return $posts;
    }
    public function createNew($content, $category, $user) : bool
    {
        try{

            $post = new Post();
            $post->setContent($content);
            $post->setCategory($category);
            $post->setCreatedBy($user);
            $post->setTitle("GenericPost");

            $entityManager = $this->getEntityManager();
            $entityManager->persist($post);
            $entityManager->flush();
        }catch(\Exception $e){
            return false;
        }
        return true;
    }

    public function create($post) : void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($post);
        $entityManager->flush();
    }

    public function deletePostById($postId) : void{

        $post = $this->findOneBy(array('id' => $postId));
        $this->remove($post);
    }


    public function remove($post) : void{

        $this->getEntityManager()->remove($post);
        $this->getEntityManager()->flush();

    }

    public function getBestPostLastHour(){

        try {
            $sql = 'SELECT post.id FROM reaction, post, category where reaction.dtype = \'postreaction\' and reaction.reaction = true	and reaction.created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR) 	and post.id = reaction.post_id	and post.category_id = category.id	group by reaction.post_id order by count(*) desc  limit 0, 1 ';
            $em = $this->getEntityManager();
            $stmt = $em->getConnection()->executeQuery($sql);

            $post = $this->findOneBy(array('id' => $stmt->fetchOne()));
            return $post;
        } catch (Exception $e) {
            return null;
        }

       // $query = $this->getEntityManager()->createNativeQuery();
     //   $query = $this->getEntityManager()->create
    //    $post = $query->getResult();
/*
        $this->createQueryBuilder('p')->
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
*/
    //    return $post;

    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
