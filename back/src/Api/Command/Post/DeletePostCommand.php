<?php

namespace App\Api\Command\Post;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class DeletePostCommand
{
    /**
     * @var int
     * @Assert\Type(type="int")
     * @Assert\NotNull
     */
    private $id;

    /**
     * @var User
     * @Assert\NotNull
     */
    private $user;

    public function __construct(int $id, User $user)
    {
        $this->id = $id;
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
