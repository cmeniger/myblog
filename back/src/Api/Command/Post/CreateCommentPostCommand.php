<?php

namespace App\Api\Command\Post;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class CreateCommentPostCommand
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
    private $content;

    /**
     * @var ?User
     */
    private $author;

    public function __construct(int $id, string $content, ?User $author = null)
    {
        $this->id = $id;
        $this->content = $content;
        $this->author = $author;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }
}
