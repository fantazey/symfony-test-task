<?php

namespace App\Repository;

use App\Entity\Appraisal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Appraisal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appraisal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appraisal[]    findAll()
 * @method Appraisal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppraisalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Appraisal::class);
    }

    public function findUpdatedAppraisals(int $limit, int $offset)
    {
        return $this->createQueryBuilder('a')
            ->where('a.average_price > 0')
            ->orderBy('a.car', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()
            ->getResult()
            ;
    }

    public function countUpdatedAppraisals(): int
    {
        return $this->createQueryBuilder('a')->select('count(a.id)')
            ->where('a.average_price > 0')
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
