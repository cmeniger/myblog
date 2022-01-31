<?php

namespace App\Api\Handler\User;

use App\Api\Query\User\PostsUserQuery;
use App\Model\Post\PostList;
use App\Repository\PostRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class PostsUserHandler
{
    /** @var PostRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function handle(PostsUserQuery $postsUserQuery): PostList
    {
        $count = $this->postRepository->countBy(
            $postsUserQuery->getUser()->getId()
        );

        $rows = $this->postRepository->searchBy(
            $postsUserQuery->getPage(),
            $postsUserQuery->getLimit(),
            $postsUserQuery->getUser()->getId()
        );

        return new PostList(
            $rows,
            $count,
            $postsUserQuery->getLimit(),
            $postsUserQuery->getPage()
        );
    }
}
