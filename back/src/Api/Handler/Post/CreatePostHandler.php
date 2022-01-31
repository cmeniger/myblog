<?php

namespace App\Api\Handler\Post;

use App\Api\Command\Post\CreatePostCommand;
use App\Manager\PostManager;
use Exception;

class CreatePostHandler
{
    /** @var PostManager */
    private $postManager;

    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @throws Exception
     */
    public function handle(CreatePostCommand $createPostCommand): void
    {
        $this->postManager->createPost(
            $createPostCommand->getTitle(),
            $createPostCommand->getContent(),
            $createPostCommand->getAuthor()
        );
    }
}
