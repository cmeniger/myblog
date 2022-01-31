<?php

namespace App\Api\Factory;

use App\Api\Command\Post\CreateCommentPostCommand;
use App\Api\Command\Post\CreatePostCommand;
use App\Api\Command\Post\DeletePostCommand;
use App\Api\Command\Post\UpdatePostCommand;
use App\Api\Query\Post\CommentsPostQuery;
use App\Api\Query\Post\SearchPostQuery;
use App\Api\Query\Post\ShowPostQuery;
use App\Entity\User;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostQueryCommandFactory
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = 50;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @throws Exception
     */
    public function createSearchPostQuery(?int $limit = null, ?int $page = null): SearchPostQuery
    {
        $query = new SearchPostQuery(
            $limit ?? self::DEFAULT_LIMIT,
            $page ?? self::DEFAULT_PAGE
        );

        $validationErrors = $this->validator->validate($query);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $query;
    }

    /**
     * @throws Exception
     */
    public function createShowPostQuery(int $id): ShowPostQuery
    {
        $query = new ShowPostQuery($id);

        $validationErrors = $this->validator->validate($query);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $query;
    }

    /**
     * @throws Exception
     */
    public function createCommentsPostQuery(int $id, ?int $limit = null, ?int $page = null): CommentsPostQuery
    {
        $query = new CommentsPostQuery(
            $id,
            $limit ?? self::DEFAULT_LIMIT,
            $page ?? self::DEFAULT_PAGE
        );

        $validationErrors = $this->validator->validate($query);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $query;
    }

    /**
     * @throws Exception
     */
    public function createCreatePostCommand(string $title, string $content, User $author): CreatePostCommand
    {
        $command = new CreatePostCommand(
            $title,
            $content,
            $author
        );

        $validationErrors = $this->validator->validate($command);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $command;
    }

    /**
     * @throws Exception
     */
    public function createUpdatePostCommand(int $id, string $title, string $content, User $user): UpdatePostCommand
    {
        $command = new UpdatePostCommand(
            $id,
            $title,
            $content,
            $user
        );

        $validationErrors = $this->validator->validate($command);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $command;
    }

    /**
     * @throws Exception
     */
    public function createDeletePostCommand(int $id, User $user): DeletePostCommand
    {
        $command = new DeletePostCommand(
            $id,
            $user
        );

        $validationErrors = $this->validator->validate($command);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $command;
    }

    /**
     * @throws Exception
     */
    public function createCreateCommentPostCommand(int $id, string $content, ?User $author = null): CreateCommentPostCommand
    {
        $command = new CreateCommentPostCommand(
            $id,
            $content,
            $author
        );

        $validationErrors = $this->validator->validate($command);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $command;
    }
}
