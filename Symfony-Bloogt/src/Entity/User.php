<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity as UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @method string getUserIdentifier()
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User implements UserInterface
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
     * @ORM\JoinTable(name="user_chats",
     *      joinColumns={@ORM\JoinColumn(name="chats_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="users_involved_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $chats;
    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="createdBy", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="user_id")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="createdBy")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="Reaction", mappedBy="reactedBy", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(name="reaction_id", onDelete="CASCADE")
     */
    private $reactions;



    public function __construct()
    {



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
    public function getName(): ?string
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
    public function getSurname(): ?string
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
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt->format('Y-m-d h:m:s');
    }


    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
      //  return $this->roles;
     //   $array = array("ROLE_USER");
     //   return $array;
        return Role::RoleList($this->roles);
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
     * @return number
     */
    public function getCommentCount()
    {
        return sizeof($this->comments);
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
     * @return number
     */
    public function getPostNumber()
    {
        return sizeof($this->posts);
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts): void
    {
        $this->posts = $posts;
    }
    /**
     * @return number
     */
    public function getFollowingCount()
    {
        return sizeof($this->getFollowing());
    }

    /**
     * @return mixed
     */
    public function getReactions()
    {
        return $this->reactions;
    }


    public function getReactionOfUserOfPost(Post $post){
        foreach ($this->getReactions() as $reaction){


            if(method_exists( $reaction, 'getPost'))
                if($reaction->getPost() == $post)
                    return $reaction;

        }
        return null;

    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////
    ///         DATA PROJECTIONS
    ///

    public static function MapDataToUserDataProjection($data){
        if(is_array($data)  or $data instanceof \Doctrine\ORM\PersistentCollection){
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

        if($User ==null)
            return null;

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
            'userRoles' => $User->getRoles(),
   //         'following' => sizeof($User->getFollowing())
            'following' => User::MapDataToUserBasicDataProjection($User->getFollowing()),
            'writtenComments' => $User->getPostNumber(),
            'writtenPosts' => $User->getCommentCount()



        ];

        return $data;
    }

    public static function MapDataToUserBasicDataProjection($data){

       // var_dump($data instanceof \Doctrine\ORM\PersistentCollection);


        if(is_array($data) or $data instanceof \Doctrine\ORM\PersistentCollection){
            $dataToReturn = array();
            foreach($data as $dat) {
             //   $dataToReturn[] = User::UserBasicData($dat);
                $dataToReturn[] = User::UserBasicData($dat);
            }
            return $dataToReturn;
        }else{
            return User::UserBasicData($data);
        }
    }
    public static function UserBasicData($User){
        if($User ==null)
            return null;

        $data =[
            'id' => $User->getId(),
            'username' => $User->getUsername(),
            'name' => $User->getName(),
            'surname' => $User->getSurname(),
            'avatar' => $User->getAvatar(),
            'background' => $User->getBackground()
        ];

        return $data;
    }

    /**
     * Returns the salt that was originally used to hash the password.
     *
     * This can return null if the password was not hashed using a salt.
     *
     * This method is deprecated since Symfony 5.3, implement it from {@link LegacyPasswordAuthenticatedUserInterface} instead.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method string getUserIdentifier()
    }
}
