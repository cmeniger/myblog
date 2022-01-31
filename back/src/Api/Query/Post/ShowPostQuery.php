<?php

namespace App\Api\Query\Post;

use Symfony\Component\Validator\Constraints as Assert;

class ShowPostQuery
{
    /**
     * @var int
     * @Assert\Type(type="integer")
     * @Assert\NotNull
     */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
