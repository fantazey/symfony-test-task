<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    public function findAllWithoutAppraisalQueryBuilder()
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('App\Entity\Appraisal', 'a', Join::WITH, 'c.id = a.car')
            ->where('a.id is NULL')
            ->orderBy('c.id', 'ASC')
            //->getQuery()->getResult()
            ;
    }
}
