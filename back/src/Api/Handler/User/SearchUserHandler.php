<?php

namespace App\Api\Handler\User;

use App\Api\Query\User\SearchUserQuery;
use App\Model\User\UserList;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class SearchUserHandler
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function handle(SearchUserQuery $searchUserQuery): UserList
    {
        $count = $this->userRepository->countBy();

        $rows = $this->userRepository->searchBy(
            $searchUserQuery->getPage(),
            $searchUserQuery->getLimit()
        );

        return new UserList(
            $rows,
            $count,
            $searchUserQuery->getLimit(),
            $searchUserQuery->getPage()
        );
    }
}
