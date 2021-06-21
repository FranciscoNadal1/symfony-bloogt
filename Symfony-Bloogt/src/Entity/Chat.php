<?php

namespace App\Entity;

use App\Entity\User as User;
use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="chat", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="message_id")
     */
    private $messages;
     /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="chats" )
     * @var User[]
     */
    private $usersInvolved;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Message[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return mixed
     */
    public function getLastMessage()
    {

        foreach($this->getMessages() as $message);
        return $message;
    }



    /**
     * @param mixed $messages
     */
    public function setMessages($messages): void
    {
        $this->messages = $messages;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d h:m:s');
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Users[]
     */
    public function getUsersInvolved()
    {
        return $this->usersInvolved;
    }

    /**
     * @param mixed $usersInvolved
     */
    public function setUsersInvolved($usersInvolved): void
    {
        $this->usersInvolved = $usersInvolved;
    }

    /**
     * @param string $username
     * @return User|null
     */
    public function getUserExcept(string $username)
    {

        foreach($this->getUsersInvolved() as $user){

            if($user->getUsername() != $username){
                return $user;
            }
        }

        return null;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
    }



}
