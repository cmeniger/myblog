<?php

namespace App\Model;

use Symfony\Component\Serializer\Annotation\Groups;

class ApiErrorModel
{
    /**
     * @var string
     * @Groups("api")
     */
    public $error;

    public function __construct(string $error)
    {
        $this->error = $error;
    }
}
