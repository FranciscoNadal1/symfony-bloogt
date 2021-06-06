<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @ORM\Table(name="authorities", uniqueConstraints={@ORM\UniqueConstraint(name="search_idx", columns={"user_id", "authority"})})
 */
class Role
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
     * @Assert\NotNull()
     * @var string
     */
    private $authority;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * Role constructor.
     * @param string $authority
     * @param $user
     */
    public function __construct(User $user, string $authority)
    {
        $this->authority = $authority;
        $this->user = $user;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthority(): ?string
    {
        return $this->authority;
    }






    public static function RoleList($data){

        $dataToReturn = array();
        foreach($data as $dat) {
            $dataToReturn[] =  $dat->getAuthority();
        }
        return $dataToReturn;

    }
}




