<?php


namespace App\Tests\MockRepos;

use App\Entity\User;
use App\Repository\UserRepository;

class UserMockRepo extends UserRepository
{

    /** @var int */
    private $expectedId;

    /** @var User */
    private $user;

    public function __construct(User $user, int $expectedId)
    {
        $this->user = $user;
        $this->expectedId = $expectedId;
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        if ($id === $this->expectedId) {
            return $this->user;
        }

        return null;
    }
}