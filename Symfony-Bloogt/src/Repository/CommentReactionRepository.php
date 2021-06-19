<?php

namespace App\Repository;

use App\Entity\CommentReaction;
use App\Entity\Comments;
use App\Entity\Post;
use App\Entity\PostReaction;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentReaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentReaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentReaction[]    findAll()
 * @method CommentReaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentReactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentReaction::class);
    }


    public function newCommentReaction(Comments $comment, bool $reaction, User $user){
        $commentReaction = new CommentReaction();
        $commentReaction->setComment($comment);
        $commentReaction->setReaction($reaction);
        $commentReaction->setReactedBy($user);

        $entityManager = $this->getEntityManager();
        $entityManager->persist($commentReaction);
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
    //  * @return CommentReaction[] Returns an array of CommentReaction objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommentReaction
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
