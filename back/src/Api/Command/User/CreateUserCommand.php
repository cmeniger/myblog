<?php

namespace App\Api\Command\User;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserCommand
{
    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    private $email;

    /**
     * @var string
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    private $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

}
