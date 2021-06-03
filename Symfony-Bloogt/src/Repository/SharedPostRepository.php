<?php

namespace App\Repository;

use App\Entity\SharedPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SharedPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method SharedPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method SharedPost[]    findAll()
 * @method SharedPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SharedPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SharedPost::class);
    }

    // /**
    //  * @return SharedPost[] Returns an array of SharedPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SharedPost
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
