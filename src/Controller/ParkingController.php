<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ParkingRepository;
use App\Repository\OperatorRepository;
use App\Repository\PricelistRepository;
use App\Entity\Parking;
use App\Entity\Operator;
use App\Entity\Pricelist;

class ParkingController extends AbstractController
{
  private $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
    {
      $this->entityManager = $entityManager;
    }

  /**
  * @Route("/parking", name="parking")
  */
  public function index(ParkingRepository $parking, OperatorRepository $operator, PricelistRepository $price): Response
  {
    $url = 'https://data.montpellier3m.fr/sites/default/files/ressources/VilleMTP_MTP_ParkingOuv.csv';

    $handle = fopen($url, 'r');
    $linecount=true;

    while ($line = fgetcsv($handle, 0, ','))
    {
      if($linecount) {
        $linecount = false;
        continue;
      }
      $p = $price->findOneBy(['id' => 'id']);
      if(is_null($p)) {
          $p = new Pricelist;
          $p->setDuration(15);
          $p->setPrice(0.8);
          $this->entityManager->persist($p);
          $this->entityManager->flush();
      }

      $op = $operator->findOneBy(['siret' => $line[17]]);
      if(is_null($op)) {
        $op = new Operator;
        $op->setSiret($line[17]);
        $op->setName($line[32]);
        $this->entityManager->persist($op);
        $this->entityManager->flush();
      }

      $result = $parking->findOneBy(['id_ext' => $line[0]]);
      if(is_null($result)) {
        $result = new Parking();
        $result->setIdExt($line[0]);
        $result->setName($line[1]);
        $result->setAdress($line[3]);
        $result->setInsee($line[2]);
        $result->setXlong((float)$line[18]);
        $result->setYlat((float)$line[19]);
        $result->setNbPlaces($line[7]);
        $result->setOperator($op);
        $result->setPricelist($p);
        $this->entityManager->persist($result);
        $this->entityManager->flush();
      }

    }
    return $this->render('parking/index.html.twig', [
      'controller_name' => 'ParkingController - index',
    ]);
  }
}

