<?php

namespace App\Repository;

use App\Entity\PostImagePost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PostImagePost|null find($id, $lockMode = null, $lockVersion = null)
 * @method PostImagePost|null findOneBy(array $criteria, array $orderBy = null)
 * @method PostImagePost[]    findAll()
 * @method PostImagePost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostImagePostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PostImagePost::class);
    }

    // /**
    //  * @return PostImagePost[] Returns an array of PostImagePost objects
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
    public function findOneBySomeField($value): ?PostImagePost
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
