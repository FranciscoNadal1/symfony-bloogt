<?php

namespace App\Repository;

use App\Entity\CommentReaction;
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
