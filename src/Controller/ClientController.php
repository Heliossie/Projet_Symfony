<?php

namespace App\Controller;

use App\Entity\Carpark;
use App\Entity\Client;
use App\Repository\CarparkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="user")
     */
    public function index(Client $user): Response
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController - Espace Client',
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/invoices", name="invoice")
     */
    public function invoice(Client $user, CarparkRepository $carparkRepository
    ): Response
    {
        return $this->render('client/invoice.html.twig', [
            'controller_name' => 'ClientController - Factures',
            'user' => $user,
            'carparks' => $carparkRepository->findBy(['client' => $user->getId()]),

        ]);
    }
}
