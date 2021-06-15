<?php

namespace App\Entity;

use App\Repository\PostReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostReactionRepository::class)
 * 
 */
class PostReaction extends Reaction
{
    /**
     * @ORM\ManyToOne(targetEntity="Post")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id")
     */
    private $post;

    public function __construct()
    {
        parent::__construct();
    }



    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param mixed $post
     */
    public function setPost($post): void
    {
        $this->post = $post;
    }


}
