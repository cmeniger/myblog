<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countBy(?int $authorId = null): int
    {
        $qb = $this->getFilteredQueryBuilder($authorId);
        $qb->select('count(p)');

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return Post[]
     */
    public function searchBy(int $page, int $limit, ?int $authorId = null): array
    {
        $qb = $this->getFilteredQueryBuilder($authorId);

        return $qb->setFirstResult($page * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    private function getFilteredQueryBuilder(?int $authorId = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('p.deletedAt is null');

        if ($authorId !== null) {
            $qb->andWhere('p.author = :authorId');
            $qb->setParameter('authorId', $authorId);
        }

        return $qb;
    }
}
