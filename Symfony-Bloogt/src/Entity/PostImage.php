<?php

namespace App\Entity;

use App\Repository\PostImagePostRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostImagePostRepository::class)
 */
class PostImage
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image_post;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="PostImagePost", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImagePost(): ?string
    {
        return $this->image_post;
    }

    public function setImagePost(?string $image_post): self
    {
        $this->image_post = $image_post;

        return $this;
    }


    public static function PostImageList($data){

        $dataToReturn = array();
        foreach($data as $dat) {
            $dataToReturn[] =  $dat->getImagePost();
        }
        return $dataToReturn;

    }
}
