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
     * @ORM\Column(type="string", name="username", unique=true)
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
     * @Assert\Email()
     */
    private $email;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $avatar = null;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $background = null;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\NotNull
     * @var string
     * @Assert\Length(min=6)
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @var string
     */
    private $bio;
    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;
    /**
     * @ORM\OneToMany(targetEntity="Role", mappedBy="user", cascade={"all"}, fetch="LAZY"), orphanRemoval=true)
     */
    private $roles;
    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="user_following",
     *      joinColumns={@ORM\JoinColumn(name="following_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     *      )    
     */
    private $following;
    /**
     * @ORM\ManyToMany(targetEntity="Chat", cascade={"persist", "remove"})
     */
    private $chats;
    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="user", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="user")
     */
    private $comments;
/*
* @ORM\OneToMany(targetEntity="Comments", mappedBy="user", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
* @ORM\JoinColumn(name="user_id")
 */


    /**
     * User constructor.
     * @param string $username
     * @param string $name
     * @param string $surname
     * @param string $email
     * @param string $avatar
     * @param string $background
     * @param string $password
     * @param string $bio
     * @param DateTime $createdAt
     * @param $roles
     */
    public function __construct()
    {
        /*
        $this->username = $username;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        */
/*
        if($this->avatar != null)
            $this->avatar = $avatar;

        if($this->background != null)
            $this->background = $background;
*/
/*
        $this->password = $password;
        $this->bio = $bio;
*/
       // $this->roles = $roles;

        $this->createdAt = new \DateTime("now");
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ///                 GETTERS AND SETTERS
    ///


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getBackground(): ?string
    {
        return $this->background;
    }

    /**
     * @param string $background
     */
    public function setBackground(string $background): void
    {
        $this->background = $background;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * @param string $bio
     */
    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d');;
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
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getFollowing()
    {
        return $this->following;
    }

    /**
     * @param mixed $following
     */
    public function setFollowing($following): void
    {
        $this->following = $following;
    }

    /**
     * @return mixed
     */
    public function getChats()
    {
        return $this->chats;
    }

    /**
     * @param mixed $chats
     */
    public function setChats($chats): void
    {
        $this->chats = $chats;
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
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         DATA PROJECTIONS
    ///

    public static function MapDataToUserDataProjection($data){
        if(is_array($data)){
            $dataToReturn = array();
            foreach($data as $dat) {
                $dataToReturn[] = User::UserData($dat);
            }
            return $dataToReturn;
        }else{
            return User::UserData($data);
        }
    }

    public static function UserData($User){

        $role = $User->getRoles();

        $data =[
            'id' => $User->getId(),
          'username' => $User->getUsername(),
            'name' => $User->getName(),
            'surname' => $User->getSurname(),

            'avatar' => $User->getAvatar(),
            'background' => $User->getBackground(),
            'bio' => $User->getBio(),
            'createdAt' => $User->getCreatedAt(),

            'email' => $User->getEmail(),
            'userRoles' => Role::RoleList($User->getRoles()),
            'following' => $User->getFollowing()
        ];

        return $data;
    }

}
