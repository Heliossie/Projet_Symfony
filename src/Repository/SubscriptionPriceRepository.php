<?php

namespace App\Repository;

use App\Entity\SubscriptionPrice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubscriptionPrice|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubscriptionPrice|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubscriptionPrice[]    findAll()
 * @method SubscriptionPrice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionPriceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubscriptionPrice::class);
    }

    // /**
    //  * @return SubscriptionPrice[] Returns an array of SubscriptionPrice objects
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

    public function findOneBySomeField($value): ?SubscriptionPrice
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.date <= :val')
            ->setParameter('val', $value)
            ->orderBy('s.date', 'DESC')
            ->getQuery()
            ->getOneOrNullResult();
    }
}
