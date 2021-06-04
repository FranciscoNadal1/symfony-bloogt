<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
     /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
     /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var string
     */
    private $title;
    /**
    * @ORM\Column(type="simple_array")
    */
    private $imagePost;
     /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;
     /**
     * @ORM\Column(type="blob")
     * @Assert\NotNull()
     * @var string
     */
    private $content;

  /**
     * @ORM\ManyToMany(targetEntity="Hashtag", cascade={"persist", "remove"})
     */
    private $hashtags;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $comments;
    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $createdBy;
    /**
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist", "remove"})
     */
    private $category;
     /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $timesViewed;

    /**
     * @ORM\OneToMany(targetEntity="PostReaction", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $reaction;



    ////////////////    Only for shared Posts

    public $isShared;
    public $sharedBy;
    public $sharedAt;


    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///                 GETTERS AND SETTERS
    ///
    /**
     * Post constructor.
     * @param $id
     * @param string $title
     * @param $imagePost
     * @param DateTime $createdAt
     * @param string $content
     * @param $hashtags
     * @param $comments
     * @param $createdBy
     * @param $category
     * @param int $timesViewed
     * @param $reaction
     */

    public function __construct(string $title, DateTime $createdAt, string $content, $hashtags, $comments, $createdBy, $category, int $timesViewed, $reaction)
    {

        $this->title = $title;
        $this->createdAt = $createdAt;
        $this->content = $content;
        $this->hashtags = $hashtags;
        $this->comments = $comments;
        $this->createdBy = $createdBy;
        $this->category = $category;
        $this->timesViewed = $timesViewed;
        $this->reaction = $reaction;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getImagePost()
    {
        return $this->imagePost;
    }

    /**
     * @param mixed $imagePost
     */
    public function setImagePost($imagePost): void
    {
        $this->imagePost = $imagePost;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getHashtags()
    {
        return $this->hashtags;
    }

    /**
     * @param mixed $hashtags
     */
    public function setHashtags($hashtags): void
    {
        $this->hashtags = $hashtags;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments): void
    {
        $this->comments = $comments;
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
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return int
     */
    public function getTimesViewed(): int
    {
        return $this->timesViewed;
    }

    /**
     * @param int $timesViewed
     */
    public function setTimesViewed(int $timesViewed): void
    {
        $this->timesViewed = $timesViewed;
    }

    /**
     * @return mixed
     */
    public function getReaction()
    {
        return $this->reaction;
    }

    /**
     * @param mixed $reaction
     */
    public function setReaction($reaction): void
    {
        $this->reaction = $reaction;
    }

    /**
     * @return mixed
     */
    public function getIsShared()
    {
        return $this->isShared;
    }

    /**
     * @param mixed $isShared
     */
    public function setIsShared($isShared): void
    {
        $this->isShared = $isShared;
    }

    /**
     * @return mixed
     */
    public function getSharedBy()
    {
        return $this->sharedBy;
    }

    /**
     * @param mixed $sharedBy
     */
    public function setSharedBy($sharedBy): void
    {
        $this->sharedBy = $sharedBy;
    }

    /**
     * @return mixed
     */
    public function getSharedAt()
    {
        return $this->sharedAt;
    }

    /**
     * @param mixed $sharedAt
     */
    public function setSharedAt($sharedAt): void
    {
        $this->sharedAt = $sharedAt;
    }







}