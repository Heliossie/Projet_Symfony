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
    
    public function findByPrice($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere("p.duration >= :val")
            ->setParameter('val', $value)
            ->orderBy('p.price', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }
    
    // public function findByPrice()
    // {
    //     $em = $this->getEntityManager();
    //     $query = $em->createQuery(
    //         "SELECT p.price FROM App\Entity\Pricelist p WHERE p.duration<='00:00:30'  ORDER BY p.price DESC"
    //     );

    //     return $query->getResult()
    //     ;
    // }

    
    // public function findOneBySomeField($value): ?Pricelist
    // {
    //     return $this->createQueryBuilder('p')
    //         ->andWhere('p.duration <= :val')
    //         ->setParameter('val', $value)
    //         ->orderBy('p.price', 'DESC')
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }
    
}
