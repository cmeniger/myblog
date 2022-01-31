<?php

namespace App\Manager;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class PostManager
{
    /** @var PostRepository */
    private $postRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(PostRepository $postRepository, EntityManagerInterface $entityManager)
    {
        $this->postRepository = $postRepository;
        $this->entityManager = $entityManager;
    }

    public function getPost(int $id): Post
    {
        $post = $this->postRepository->find($id);

        if ($post === null || $post->getDeletedAt() !== null) {
            throw new NotFoundHttpException('Post not found');
        }

        return $post;
    }

    /**
     * @throws Exception
     */
    public function createPost(string $title, string $content, User $author): Post
    {
        if ($this->postRepository->findOneBy(['title' => $title, 'author' => $author]) !== null) {
            throw new Exception('Post with same title already exist');
        }

        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);
        $post->setAuthor($author);
        $post->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($post);
        $this->entityManager->flush($post);

        return $post;
    }

    /**
     * @throws Exception
     */
    public function updatePost(int $id, string $title, string $content, User $user): Post
    {
        $post = $this->postRepository->find($id);

        if ($post === null) {
            throw new NotFoundHttpException('Post not found');
        }
        if ($post->getAuthor() !== null && $post->getAuthor()->getId() !== $user->getId()) {
            throw new UnauthorizedHttpException('Not authorized');
        }

        $post->setTitle($title);
        $post->setContent($content);
        $post->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->flush($post);

        return $post;
    }

    public function deletePost(int $id, User $user): Post
    {
        $post = $this->postRepository->find($id);

        if ($post === null) {
            throw new NotFoundHttpException('Post not found');
        }
        if ($post->getAuthor() !== null && $post->getAuthor()->getId() !== $user->getId()) {
            throw new UnauthorizedHttpException('Not authorized');
        }

        $post->setDeletedAt(new \DateTimeImmutable());

        $this->entityManager->flush($post);

        return $post;
    }
}
