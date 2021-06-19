<?php

namespace App\Repository;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->entityManager = $this->getEntityManager();
        parent::__construct($registry, User::class);
    }

    public function save($user) : bool{
        try{
        //    $entityManager = $this->getEntityManager();
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
        }catch(\Exception $e){
            return false;
        }
        return true;

}
    public function newUser($username, $password, $name, $surname, $email, $bio) : User
    {
        $user = new User();
        try {

            $user->setUsername($username);
            $user->setPassword($password);
            $user->setName($name);
            $user->setSurname($surname);
            $user->setEmail($email);
            $user->setBio($bio);

            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();

            $roles = new Role($user, "ROLE_USER");

            $this->getEntityManager()->persist($roles);
            $this->getEntityManager()->flush();

            $user->setRoles($roles);


        } catch (\Exception $e) {
            print_r($e);
            return null;
        }
  //      $returnedUser = $this->findOneBy(array('username' => $username));
        $returnedUser = $user;

        return $returnedUser;
    }

    public function remove($user) : bool{

        try{
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();
                return true;
        }catch(\Exception $e){
            return false;
        }

    }
    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

/*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
*/

    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
