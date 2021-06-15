<?php

namespace App\Entity;

use App\Repository\ReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReactionRepository::class)
 * @ORM\InheritanceType("SINGLE_TABLE")
 */
abstract class Reaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $reaction;
    /*
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="reactedBy", referencedColumnName="id", unique=true)}
     *      )    
     */
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $reactedBy;
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;

    public function __construct()
    {

        $this->createdAt = new \DateTime("now");
    }






    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isReaction(): bool
    {
        return $this->reaction;
    }

    /**
     * @param bool $reaction
     */
    public function setReaction(bool $reaction): void
    {
        $this->reaction = $reaction;
    }

    /**
     * @return mixed
     */
    public function getReactedBy()
    {
        return $this->reactedBy;
    }

    /**
     * @param mixed $reactedBy
     */
    public function setReactedBy($reactedBy): void
    {
        $this->reactedBy = $reactedBy;
    }

    /**
     * @return String
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


}
