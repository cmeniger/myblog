<?php

namespace App\Repository;

use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function countBy(
        ?int $postId = null,
        ?int $authorId = null
    ): int
    {
        $qb = $this->getFilteredQueryBuilder($postId, $authorId);
        $qb->select('count(c)');

        return (int)$qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return Comment[]
     */
    public function searchBy(
        int $page,
        int $limit,
        ?int $postId = null,
        ?int $authorId = null
    ): array
    {
        $qb = $this->getFilteredQueryBuilder($postId, $authorId);

        return $qb->setFirstResult($page * $limit)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    private function getFilteredQueryBuilder(?int $postId = null, ?int $authorId = null): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c');
        $qb->andWhere('c.deletedAt is null');

        if ($postId !== null) {
            $qb->andWhere('c.post = :postId');
            $qb->setParameter('postId', $postId);
        }

        if ($authorId !== null) {
            $qb->andWhere('c.author = :authorId');
            $qb->setParameter('authorId', $authorId);
        }

        return $qb;
    }
}
