<?php

namespace App\Api\Handler\Post;

use App\Api\Query\Post\ShowPostQuery;
use App\Entity\Post;
use App\Manager\PostManager;

class ShowPostHandler
{
    /** @var PostManager */
    private $postManager;

    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    public function handle(ShowPostQuery $searchPostQuery): Post
    {
        return $this->postManager->getPost($searchPostQuery->getId());
    }
}
