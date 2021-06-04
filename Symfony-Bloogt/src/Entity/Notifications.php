<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=NotificationsRepository::class)
 */
class Notifications
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @var string
     */
    private $notificationType;
     /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $isRead;
    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $notificationOf;
    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id", unique=true)}
     *      )    
     */   
    private $relatedWith;
    /**
     * @ORM\ManyToOne(targetEntity="Post", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="Post",
     *      joinColumns={@ORM\JoinColumn(name="post", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="post", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $relatedPost;
    /**
     * @ORM\ManyToOne(targetEntity="Comments", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="Comments",
     *      joinColumns={@ORM\JoinColumn(name="comments", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comments", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $relatedComment;

    public function getId(): ?int
    {
        return $this->id;
    }
}
