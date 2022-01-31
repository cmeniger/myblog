<?php

namespace App\Api\Command\Post;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePostCommand
{
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
    private $author;

    public function __construct(string $title, string $content, User $author)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): User
    {
        return $this->author;
    }
}
