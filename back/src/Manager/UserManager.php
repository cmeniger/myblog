<?php

namespace App\Manager;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    /** @var UserPasswordHasherInterface */
    private $userPasswordHasher;

    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var JWTTokenManagerInterface */
    private $JWTTokenManager;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $JWTTokenManager
    )
    {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->JWTTokenManager = $JWTTokenManager;
    }

    /**
     * @throws Exception
     */
    public function createUser(string $email, string $password, bool $isAdmin = false): User
    {
        if ($this->userRepository->findOneBy(['email' => $email]) !== null) {
            throw new Exception('User with same email already exist');
        }

        $user = new User();

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $password
        );

        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setRoles($isAdmin === true ? ['ROLE_ADMIN'] : ['ROLE_USER']);

        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        return $user;
    }

    public function getToken(User $user): string
    {
        return $this->JWTTokenManager->create($user);
    }
}
