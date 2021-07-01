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
    
    public function monthlyCarparks($month, $year, $client)
    {
        // $conn= $this->getEntityManager()->getConnection();
        // $sql = '
        //     SELECT * FROM carpark
        //     WHERE MONTH(departure) = :month
        //     AND YEAR(departure) = :year
        //     AND client_id= :id
        // ';
        // $stmt = $conn->prepare($sql);
        // $stmt->bindParam()
        // $stmt->execute(['month' => $month, 'year' => $year, 'id' => $id]);
        
        // $em = $this->getEntityManager();
        // $emConfig = $em->getConfiguration();
        // $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensionsQueryMysqlYear');
        // $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensionsQueryMysqlMonth');

       $query = $this->createQueryBuilder('c')
    //    ->select('c.*')
       ->andWhere('MONTH(c.departure) = :month')
       ->andWhere('YEAR(c.departure) = :year')
       ->andWhere('c.client = :client')
       ->setParameter('client', $client)
       ->setParameter('month', $month)
       ->setParameter('year', $year)
       ->getQuery()
       ;

       return $query->getResult();

    }
    
    // public function monthlyCarparks($month, $year, $client)
    // {
    //     return $this->createQueryBuilder('c')
    //     ->where('c.departure LIKE :date')
    //     ->andWhere('c.client = :client')
    //     ->setParameter('date', $year.'-'.$month.'%')
    //     ->setParameter('client', $client)
    //     ->orderBy('c.id', 'ASC')
    //     ->setMaxResults(10)
    //     ->getQuery()
    //     ->getResult()
    // ;
    // }

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
