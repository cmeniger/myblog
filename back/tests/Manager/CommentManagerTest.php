<?php

namespace App\Tests\Manager;

use App\Entity\Post;
use App\Entity\User;
use App\Manager\CommentManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CommentManagerTest extends TestCase
{
    /** @var EntityManagerInterface|MockObject */
    private $entityManager;

    /** @var CommentManager */
    private $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->service = new CommentManager($this->entityManager);
    }

    /** @dataProvider createCommentDataProvider */
    public function testCreateComment(
        Post $post,
        string $content,
        ?User $author
    ): void
    {
        $this->entityManager->expects(self::once())->method('persist');
        $this->entityManager->expects(self::once())->method('flush');

        $comment = $this->service->createComment($post, $content, $author);

        self::assertEquals($post, $comment->getPost());
        self::assertEquals($content, $comment->getContent());
        self::assertEquals($author, $comment->getAuthor());
        self::assertNotNull($comment->getCreatedAt());
    }

    public function createCommentDataProvider(): iterable
    {
        yield 'anonymous' => [
            'post'    => new Post(),
            'content' => 'test',
            '$author' => null,
        ];

        yield 'authenticated' => [
            'post'    => new Post(),
            'content' => 'test',
            '$author' => new User(),
        ];
    }
}
