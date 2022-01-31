<?php

namespace App\Api\Handler\Post;

use App\Api\Command\Post\DeletePostCommand;
use App\Manager\PostManager;
use Exception;

class DeletePostHandler
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
    public function handle(DeletePostCommand $deletePostCommand): void
    {
        $this->postManager->deletePost($deletePostCommand->getId(), $deletePostCommand->getUser());
    }
}
