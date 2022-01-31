<?php

namespace App\Tests\Api\Handler\Post;

use App\Api\Handler\Post\ShowPostHandler;
use App\Api\Query\Post\ShowPostQuery;
use App\Entity\Post;
use App\Manager\PostManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowPostHandlerTestPhpTest extends TestCase
{
    /** @var ShowPostHandler */
    private $service;

    /** @var PostManager|MockObject */
    private $postManager;

    public function setUp(): void
    {
        parent::setUp();
        $this->postManager = $this->createMock(PostManager::class);
        $this->service = new ShowPostHandler($this->postManager);
    }

    /** @dataProvider handlerDataProvider */
    public function testHandle(
        ?Post $post,
        int $postId,
        ?string $exceptionClass,
        ?\Exception $exception
    ): void
    {
        $query = new ShowPostQuery($postId);

        if ($exception !== null) {
            $this->postManager->method('getPost')->willThrowException($exception);

            $this->expectException($exceptionClass);
            $this->service->handle($query);
            return;
        }

        $this->postManager->method('getPost')->willReturn($post);

        $result = $this->service->handle($query);

        self::assertEquals($postId, $result->getId());
    }

    public function handlerDataProvider(): iterable
    {
        $post = $this->createMock(Post::class);
        $post->method('getId')->willReturn(42);

        yield 'post not found' => [
            'post'           => null,
            'postId'         => 1,
            'exceptionClass' => NotFoundHttpException::class,
            'exception'      => new NotFoundHttpException()
        ];

        yield 'found' => [
            'post'           => $post,
            'postId'         => 42,
            'exceptionClass' => null,
            'exception'      => null
        ];
    }
}
