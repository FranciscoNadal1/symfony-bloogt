<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CommentsRepository::class)
 */
class Comments
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @var string
     * @Assert\NotNull
     * @Assert\Length(min=1)
     */
    private $message;
    /*
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id", unique=true)}
     *      )    
     */
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;
    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $removedByModerator;


    /**
     * @ORM\OneToMany(targetEntity="CommentReaction", mappedBy="comment", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="comment_id", onDelete="CASCADE")
     */
    private $reaction;

    /**
     * @ORM\OneToMany(targetEntity="Notifications", cascade={"all"},  mappedBy="relatedComment", orphanRemoval=true)
     * @ORM\JoinColumn(name="comment_id", onDelete="CASCADE")
     */
    private $notifications;


    public function __construct()
    {
        $this->setRemovedByModerator(false);
        $this->createdAt = new \DateTime("now");
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
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
     * @return mixed
     */
    public function getReaction()
    {
        return $this->reaction;
    }
    /**
     * @return number
     */
    public function getReactionCount()
    {
        if(!isset($this->reaction))
            return 0;
        return sizeof($this->reaction);
    }


    /**
     * @return number
     */
    public function getPositiveReactionCount()
    {
        $positiveReactionCount = 0;
        foreach ($this->reaction as $dat){
            if($dat->isReaction() == true){
                $positiveReactionCount++;
            }
        }
        return $positiveReactionCount;
    }


    /**
     * @return number
     */
    public function getNegativeReactionCount()
    {
        $negativeReactionCount = 0;
        foreach ($this->reaction as $dat){
            if($dat->isReaction() == false){
                $negativeReactionCount++;
            }
        }
        return $negativeReactionCount;
    }
    /**
     * @param mixed $reaction
     */
    public function setReaction($reaction): void
    {
        $this->reaction = $reaction;
    }

    /**
     * @return bool
     */
    public function isRemovedByModerator(): bool
    {
        return $this->removedByModerator;
    }

    /**
     * @param bool $removedByModerator
     */
    public function setRemovedByModerator(bool $removedByModerator): void
    {
        $this->removedByModerator = $removedByModerator;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         DATA PROJECTIONS
    ///

    public static function MapDataToCommentsDataProjection($data){
        if(is_array($data)  or $data instanceof \Doctrine\ORM\PersistentCollection){
            $dataToReturn = array();
            foreach($data as $dat) {
                $dataToReturn[] = Comments::CommentsData($dat);
            }
            return $dataToReturn;
        }else{
            return Comments::CommentsData($data);
        }
    }


    public static function CommentsData($Comment){


        $data =[
            'id' => $Comment->getId(),
           'createdBy' => User::MapDataToUserBasicDataProjection($Comment->getCreatedBy()),
            'message' => $Comment->getMessage(),
            'createdAt' => $Comment->getCreatedAt(),
            'postId' => $Comment->getPost()->getId(),
            'post' => Post::MapDataToPostMinDataProjection($Comment->getPost()),
            'totalReactions' => 9999,
            'negativeReactions' => 9999,
            'negativeReactions' => 9999,
            'removedByModerator' => $Comment->isRemovedByModerator(),
            'positiveReactions' => 9999,
        ];

        return $data;
    }

}
