<?php

namespace App\Api\Handler\User;

use App\Api\Command\User\CreateUserCommand;
use App\Manager\UserManager;
use Exception;

class CreateUserHandler
{
    /** @var UserManager */
    private $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @throws Exception
     */
    public function handle(CreateUserCommand $createUserCommand): string
    {
        $user = $this->userManager->createUser($createUserCommand->getEmail(), $createUserCommand->getPassword());

        return $this->userManager->getToken($user);
    }
}
