<?php

namespace App\Api\Handler\Post;

use App\Api\Query\Post\SearchPostQuery;
use App\Model\Post\PostList;
use App\Repository\PostRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class SearchPostHandler
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
    public function handle(SearchPostQuery $searchPostQuery): PostList
    {
        $count = $this->postRepository->countBy();

        $rows = $this->postRepository->searchBy(
            $searchPostQuery->getPage(),
            $searchPostQuery->getLimit()
        );

        return new PostList(
            $rows,
            $count,
            $searchPostQuery->getLimit(),
            $searchPostQuery->getPage()
        );
    }
}
