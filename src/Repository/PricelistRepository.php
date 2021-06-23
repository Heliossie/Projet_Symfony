<?php

namespace App\Repository;

use App\Entity\Pricelist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pricelist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pricelist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pricelist[]    findAll()
 * @method Pricelist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricelistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pricelist::class);
    }

    // /**
    //  * @return Pricelist[] Returns an array of Pricelist objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pricelist
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
