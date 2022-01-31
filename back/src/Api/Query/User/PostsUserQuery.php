<?php

namespace App\Api\Query\User;

use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class PostsUserQuery
{
    /**
     * @var User
     * @Assert\NotNull
     */
    private $user;

    /**
     * @var int
     * @Assert\Type(type="integer")
     * @Assert\NotNull
     */
    private $limit;

    /**
     * @var int
     * @Assert\Type(type="integer")
     * @Assert\NotNull
     */
    private $page;

    public function __construct(User $user, int $limit, int $page)
    {
        $this->user = $user;
        $this->limit = $limit;
        $this->page = $page - 1;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }
}
