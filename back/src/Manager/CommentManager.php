<?php

namespace App\Manager;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class CommentManager
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function createComment(Post $post, string $content, ?User $author = null): Comment
    {
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setContent($content);
        $comment->setAuthor($author);
        $comment->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($comment);
        $this->entityManager->flush($comment);

        return $comment;
    }
}
