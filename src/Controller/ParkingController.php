<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParkingController extends AbstractController
{
    /**
     * @Route("/parking", name="parking")
     */
    public function index(): Response
    {
        return $this->render('parking/index.html.twig', [
            'controller_name' => 'ParkingController - index',
        ]);
    }

    /**
     * @Route("/user/{id}/carpark", name="carpark")
     */
    public function carpark(Client $user): Response
    {
        return $this->render('parking/carpark.html.twig', [
            'controller_name' => 'ParkingController - carpark',
        ]);
    }
}
