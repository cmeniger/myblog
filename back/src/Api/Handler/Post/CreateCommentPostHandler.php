<?php

namespace App\Api\Handler\Post;

use App\Api\Command\Post\CreateCommentPostCommand;
use App\Entity\Comment;
use App\Manager\CommentManager;
use App\Manager\PostManager;
use Exception;

class CreateCommentPostHandler
{
    /** @var CommentManager */
    private $commentManager;

    /** @var PostManager */
    private $postManager;

    public function __construct(
        CommentManager $commentManager,
        PostManager $postManager
    )
    {
        $this->commentManager = $commentManager;
        $this->postManager = $postManager;
    }

    /**
     * @throws Exception
     */
    public function handle(CreateCommentPostCommand $createCommentPostCommand): Comment
    {
        $post = $this->postManager->getPost($createCommentPostCommand->getId());

        return $this->commentManager->createComment(
            $post,
            $createCommentPostCommand->getContent(),
            $createCommentPostCommand->getAuthor()
        );
    }
}
