<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\PostReaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostReaction[]    findAll()
 * @method PostReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostReaction::class);
    }



    public function newPostReaction(Post $post, bool $reaction, User $user){
        $postReaction = new PostReaction();
        $postReaction->setPost($post);
        $postReaction->setReaction($reaction);
        $postReaction->setReactedBy($user);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($postReaction);
        $entityManager->flush();



    }

    public function remove($reaction) : bool{

        try{
            $this->getEntityManager()->remove($reaction);
            $this->getEntityManager()->flush();
            return true;
        }catch(\Exception $e){
            return false;
        }

    }


    // /**
    //  * @return PostReaction[] Returns an array of PostReaction objects
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
    public function findOneBySomeField($value): ?PostReaction
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
