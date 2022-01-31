<?php

namespace App\Api\Factory;

use App\Api\Command\User\CreateUserCommand;
use App\Api\Query\User\PostsUserQuery;
use App\Api\Query\User\SearchUserQuery;
use App\Entity\User;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserQueryCommandFactory
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
    public function createSearchUserQuery(?int $limit = null, ?int $page = null): SearchUserQuery
    {
        $query = new SearchUserQuery(
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
    public function createPostsUserQuery(User $user, ?int $limit = null, ?int $page = null): PostsUserQuery
    {
        $query = new PostsUserQuery(
            $user,
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
    public function createCreateUserCommand(string $email, string $password): CreateUserCommand
    {
        $query = new CreateUserCommand(
            $email,
            $password
        );

        $validationErrors = $this->validator->validate($query);
        if (count($validationErrors) > 0) {
            throw new Exception($validationErrors);
        }

        return $query;
    }
}
