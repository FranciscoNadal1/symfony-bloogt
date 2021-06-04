<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
    private $name;
    
      /**
     * @ORM\ManyToMany(targetEntity="Hashtag", cascade={"persist", "remove"})
     */
    private $hashtags;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category", cascade={"all"}, fetch="LAZY"), orphanRemoval=true)
     * @ORM\JoinColumn(name="post_id")
     */
    private $posts;

    public function getId(): ?int
    {
        return $this->id;
    }
}
