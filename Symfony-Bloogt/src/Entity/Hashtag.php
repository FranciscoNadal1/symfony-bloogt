<?php

namespace App\Entity;

use App\Repository\HashtagRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HashtagRepository::class)
 */
class Hashtag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
        /**
     * @ORM\Column(type="string", unique="true")
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Hashtag", mappedBy="hashtags" )  
     */
    private $posts;

    public function getId(): ?int
    {
        return $this->id;
    }
}
