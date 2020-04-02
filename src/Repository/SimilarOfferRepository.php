<?php

namespace App\Repository;

use App\Entity\SimilarOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method SimilarOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method SimilarOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method SimilarOffer[]    findAll()
 * @method SimilarOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SimilarOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SimilarOffer::class);
    }

    // /**
    //  * @return SimilarOffer[] Returns an array of SimilarOffer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SimilarOffer
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
