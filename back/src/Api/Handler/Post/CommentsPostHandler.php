<?php

namespace App\Api\Handler\Post;

use App\Api\Query\Post\CommentsPostQuery;
use App\Manager\PostManager;
use App\Model\Comment\CommentList;
use App\Repository\CommentRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class CommentsPostHandler
{
    /** @var CommentRepository */
    private $commentRepository;

    /** @var PostManager */
    private $postManager;

    public function __construct(
        CommentRepository $commentRepository,
        PostManager $postManager
    )
    {
        $this->commentRepository = $commentRepository;
        $this->postManager = $postManager;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function handle(CommentsPostQuery $commentsPostQuery): CommentList
    {
        $this->postManager->getPost($commentsPostQuery->getId());

        $count = $this->commentRepository->countBy(
            $commentsPostQuery->getId()
        );

        $rows = $this->commentRepository->searchBy(
            $commentsPostQuery->getPage(),
            $commentsPostQuery->getLimit(),
            $commentsPostQuery->getId()
        );

        return new CommentList(
            $rows,
            $count,
            $commentsPostQuery->getLimit(),
            $commentsPostQuery->getPage()
        );
    }
}
