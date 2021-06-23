<?php

namespace App\Repository;

use App\Entity\Carpark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Carpark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carpark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carpark[]    findAll()
 * @method Carpark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarparkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carpark::class);
    }

    // /**
    //  * @return Carpark[] Returns an array of Carpark objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Carpark
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
