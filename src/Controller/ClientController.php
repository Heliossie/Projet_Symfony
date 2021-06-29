<?php

namespace App\Controller;

use App\Entity\Parking;
use App\Form\UserEditFormType;
use App\Form\ClientEditFormType;
use App\Repository\CarparkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ParkingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
     * @Route("/user/invoice", name="user_invoice")
     */
    public function invoice(CarparkRepository $carparkRepository): Response
    {
        $user = $this->security->getUser();
        $invoices = $carparkRepository->findBy(['invoice' => $user->getUserIdentifier()]);

        return $this->render('client/invoice.html.twig', [
            'controller_name' => 'ClientController - Factures',
            'user' => $user,
            'invoices' => $invoices,
        ]);
    }

    /**
     * @Route("/user/carpark", name="user_carpark")
     */
    public function carpark(CarparkRepository $carparkRepository, ParkingRepository $parkingRepository): Response
    {
        $user = $this->security->getUser();

        return $this->render('parking/carpark.html.twig', [
            'controller_name' => 'ParkingController - carpark',
            'user' => $user,
            'carparks' => $carparkRepository->findBy(['client' => $user->getUserIdentifier()]),
            'parkings' => $parkingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/user/edit", name="user_edit")
     */
    public function edituser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $this->getUser();
        $client = $user->getClient();
        $form_client = $this->createForm(ClientEditFormType::class, $client);
        $form_client->handleRequest($request);
        $form_user = $this->createForm(UserEditFormType::class, $user);
        $form_user->handleRequest($request);

        if ($form_client->isSubmitted() && $form_client->isValid()) {
            //Modification des données clients
            $user->setClient($form_client->getData());
            $client = $user->getClient();
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('user');
        }

        if ($form_user->isSubmitted() && $form_user->isValid()) {
            //Modification des données user
            $pwd = $form_user->get('password')->getdata();
            $user->setPassword($passwordHasher->hashPassword($user, $pwd));
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user');
        }

        return $this->render('client/edit.html.twig', [
            'user' => $user,
            'form_client' => $form_client->createView(),
            'form_user' => $form_user->createView(),
        ]);
    }

}
