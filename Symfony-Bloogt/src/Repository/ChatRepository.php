<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Chat;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chat[]    findAll()
 * @method Chat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    public function newChat(User $user1, string $message, User $user2) : void{

        /** @var Chat|null $chat */
        $chat = new Chat();

        /** @var Message[]|null $messageObject */
        $messageObject[] = new Message($message, $user1);

        /** @var User[]|null $userObject */
        $userObject[] = $user1;
        $chat->setUsersInvolved($userObject);
        $chat->setMessages($messageObject);
        $this->save($chat);
    }

    public function save($chat) : bool{
        try{
            $entityManager = $this->getEntityManager();
            $entityManager->persist($chat);
            $entityManager->flush();
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
    // /**
    //  * @return Chat[] Returns an array of Chat objects
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
    public function findOneBySomeField($value): ?Chat
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
