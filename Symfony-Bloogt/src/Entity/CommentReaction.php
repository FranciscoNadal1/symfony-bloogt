<?php

namespace App\Entity;

use App\Repository\CommentReactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentReactionRepository::class)
 */
class CommentReaction extends Reaction
{

    /**
     * @ORM\ManyToOne(targetEntity="Comments")
     * @ORM\JoinColumn(name="comment_id", referencedColumnName="id")
     */
    private $comment;

}
