<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function newCategory($categoryName) : void{

        $category = new Category();
        $category->setName($categoryName);

        $this->save($category);

    }
    public function deleteCategoryById($categoryId) : void{

        $category = $this->findOneBy(array('id' => $categoryId));
        $this->remove($category);



    }
    public function remove($category) : void{
/*
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($category);
        $entityManager->flush();
*/
        $this->getEntityManager()->remove($category);
        $this->getEntityManager()->flush();
        /*
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($category);
        $em->flush();
*/
    }


        public function save($category) : bool{
        try{
            $entityManager = $this->getEntityManager();
            $entityManager->persist($category);
            $entityManager->flush();
        }catch(\Exception $e){
            return false;
        }
        return true;
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
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
