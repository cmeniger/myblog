<?php

namespace App\Api\Handler\Post;

use App\Api\Command\Post\UpdatePostCommand;
use App\Entity\Post;
use App\Manager\PostManager;
use Exception;

class UpdatePostHandler
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
    public function handle(UpdatePostCommand $updatePostCommand): Post
    {
        return $this->postManager->updatePost(
            $updatePostCommand->getId(),
            $updatePostCommand->getTitle(),
            $updatePostCommand->getContent(),
            $updatePostCommand->getUser()
        );
    }
}
