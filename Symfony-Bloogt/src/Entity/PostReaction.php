<?php

namespace App\Entity;

use App\Repository\PostReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostReactionRepository::class)
 */
class PostReaction extends Reaction
{
    /**
     * @ORM\OneToOne(targetEntity="Post")
     */
    private $post;

}
