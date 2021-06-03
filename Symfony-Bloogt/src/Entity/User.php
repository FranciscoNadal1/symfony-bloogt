<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     * @var string
     * @Assert\NotBlank()
     */
    private $username;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotNull
     * @Assert\NotBlank()
     * @Assert\Length(min=3)
     * @var string
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var string
     */
    private $surname;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var string
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     * @var string
     * @Assert\Email()
     * @Assert\NotNull
     * @Assert\NotBlank()
     */
    private $avatar;
    /**
     * @ORM\Column(type="string")
     * @var string
     * @Assert\NotBlank()
     */
    private $background;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @var string
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @var string
     * @Assert\NotNull
     * @Assert\Length(min=6)
     */
    private $bio;
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;
    /**
     * @ORM\OneToMany(targetEntity="Role", cascade={"all"}, fetch="LAZY"), orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $roles;
    /**
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $following;
    /**
     * @ORM\ManyToOne(targetEntity="Chat", cascade={"persist", "remove"})
     * @JoinTable(name="user_following",
     *      joinColumns={@JoinColumn(name="following_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $chats;
    /**
     * @ORM\OneToMany(targetEntity="Comments", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $comments;
    /**
     * @ORM\OneToMany(targetEntity="Post", , cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $posts;

    public function getId(): ?int
    {
        return $this->id;
    }
}
