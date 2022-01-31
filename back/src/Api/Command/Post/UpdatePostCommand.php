<?php

namespace App\Api\Command\Post;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class UpdatePostCommand
{
    /**
     * @var int
     * @Assert\Type(type="int")
     * @Assert\NotNull
     */
    private $id;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    private $title;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    private $content;

    /**
     * @var User
     * @Assert\NotNull
     */
    private $user;

    public function __construct(int $id, string $title, string $content, User $user)
    {
        $this->title = $title;
        $this->content = $content;
        $this->user = $user;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
