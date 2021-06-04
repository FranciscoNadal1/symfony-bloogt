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
    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="User",
     *      joinColumns={@ORM\JoinColumn(name="user", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="reactedBy", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $reactedBy;
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }
}
