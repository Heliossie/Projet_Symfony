<?php

namespace App\Controller;

use App\Repository\CarparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ClientController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        $user = $this->security->getUser();

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController - Espace Client',

            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/invoice", name="invoice")
     */
    public function invoice(CarparkRepository $carparkRepository): Response
    {
        $user = $this->security->getUser();

        return $this->render('client/invoice.html.twig', [
            'controller_name' => 'ClientController - Factures',
            'user' => $user,
            'carparks' => $carparkRepository->findBy(['client' => $user->getUserIdentifier()]),

        ]);
    }

    /**
     * @Route("/user/carpark", name="carpark")
     */
    public function carpark(CarparkRepository $carparkRepository): Response
    {
        $user = $this->security->getUser();

        return $this->render('parking/carpark.html.twig', [
            'controller_name' => 'ParkingController - carpark',
            'user' => $user,
            'carparks' => $carparkRepository->findBy(['client' => $user->getUserIdentifier()]),
        ]);
    }
}
