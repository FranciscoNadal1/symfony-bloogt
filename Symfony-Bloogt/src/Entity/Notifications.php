<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Uuid;

/**
 * @ORM\Entity(repositoryClass=NotificationsRepository::class)
 */
class Notifications
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
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
    /*
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )    
     */
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $notificationOf;
    /*
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="notification_author_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )    
     */
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="notification_author_id", referencedColumnName="id")
     */
    private $relatedWith;
    /*
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinTable(name="Post",
     *      joinColumns={@ORM\JoinColumn(name="related_post_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="post_id", referencedColumnName="id", unique=true)}
     *      )    
     */
    /**
     * @ORM\ManyToOne(targetEntity="Post")
     */
    private $relatedPost;
    /*
     * @ORM\ManyToOne(targetEntity="Comments")
     * @ORM\JoinTable(name="Comments",
     *      joinColumns={@ORM\JoinColumn(name="related_comment_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id", unique=true)}
     *      )    
     */
    /**
     * @ORM\ManyToOne(targetEntity="Comments")
     */
    private $relatedComment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
  //      $this->id = Uuid::uuid2();
    }
}
