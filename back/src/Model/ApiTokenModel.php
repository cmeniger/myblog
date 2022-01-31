<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\Groups;

class ApiTokenModel
{
    /**
     * @var string
     * @Groups("api")
     */
    public $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }
}
