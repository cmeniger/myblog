<?php

namespace App\Model\User;

use App\Entity\User;

class UserList
{
    /** @var User[] */
    private $entries;

    /** @var int */
    private $total;

    /** @var int */
    private $limit;

    /** @var int */
    private $page;

    public function __construct(array $entries, int $total, int $limit, int $page)
    {
        $this->entries = $entries;
        $this->total = $total;
        $this->limit = $limit;
        $this->page = $page;
    }

    /** @return User[] */
    public function getEntries(): array
    {
        return $this->entries;
    }

    public function getTotal(): int
    {
        return $this->total;
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
