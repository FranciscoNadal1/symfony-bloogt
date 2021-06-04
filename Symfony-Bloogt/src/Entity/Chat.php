<?php

namespace App\Entity;

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
     * @ORM\OneToMany(targetEntity="Message", mappedBy="message", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="message_id")
     */
    private $messages;
     /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="User" )  
     */
    private $usersInvolved;

    public function getId(): ?int
    {
        return $this->id;
    }
}
