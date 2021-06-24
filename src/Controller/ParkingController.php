<?php

namespace App\Controller;

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
}
