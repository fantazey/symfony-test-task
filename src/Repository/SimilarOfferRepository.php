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
}
