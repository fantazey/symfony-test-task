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


    // /**
    //  * @return Appraisal[] Returns an array of Appraisal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Appraisal
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
