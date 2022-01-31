<?php

namespace App\Api\Query\Post;

use Symfony\Component\Validator\Constraints as Assert;

class SearchPostQuery
{
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

    public function __construct(int $limit, int $page)
    {
        $this->limit = $limit;
        $this->page = $page - 1;
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
