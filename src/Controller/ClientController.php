<?php

namespace App\Controller;

use App\Entity\Carpark;
use App\Entity\Invoice;
use App\Entity\Parking;
use App\Form\UserEditFormType;
use App\Form\ClientEditFormType;
use App\Form\ParkingListFormType;
use App\Repository\CarparkRepository;
use App\Repository\InvoiceRepository;
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
     * @Route("/user/invoice/{id}", name="user_invoice_current")
     */
    public function currentInvoice($id,CarparkRepository $carparkRepository): Response
    {
        // récupération des objets
        $user = $this->getUser();
        $carpark = $carparkRepository->findOneBy(['id' => $id]);
        // calcul de la durée de stationnement
        $arrival_date = $carpark->getArrival();
        $departure_date = new \DateTime();
        $carpark->setDeparture($departure_date);
        $duration = date_diff($arrival_date, $departure_date);
        $duration->format('H:i:s');
        var_dump($duration);
        // récupération du prix en fonction de la durée

        // !! invoice ne sera prise en compte qu'au moment de la date de sortie du parking !!
        // On détermine si le client a déjà stationné dans le mois en cours
        
        $current_month = $departure_date->format('n');
        $current_year = $departure_date->format('Y');
        $current_carparks= $carparkRepository->findBy(['MONTH(departure)' => $current_month,'YEAR(departure)'=>$current_year,'client' => $user->getClient()]);
        
        if ($current_carparks) 
        {
            $invoice = $current_carparks[0]->getInvoice();
        }
        else
        {
            $invoice = new Invoice();
            $year = $departure_date->format('Y');
            $month = $departure_date->format('n');
            $date_invoice = date('Y-m-d',mktime(0,0,0,$month+1,1,$year));
            // $invoice->setDate($date_invoice);
            $invoice->setAmount(0);
        }
        
        $carpark->setInvoice($invoice);

        $invoices = $carparkRepository->findBy(['invoice' => $user->getUserIdentifier()]);

        return $this->render('client/invoice.html.twig', [
            'controller_name' => 'ClientController - Factures',
            'user' => $user,
            'invoices' => $invoices,
        ]);
    }

    /**
     * @Route("/user/carpark", name="user_parking")
     */
    public function parking(CarparkRepository $carparkRepository, ParkingRepository $parkingRepository): Response
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
     * @Route("/user/carpark/{id}",name="user_carpark")
     */
    public function carpark($id, ParkingRepository $parkingRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $client = $user->getClient();
        $parking = $parkingRepository->findOneBy(['id' => $id]);
        $carpark = new Carpark;
        $arrival_date = new \DateTime();
        $carpark->setArrival($arrival_date);
        $carpark->setParking($parking);
        $carpark->setClient($client);
        $em->persist($carpark);
        $em->flush();

        

        return $this->render('parking/carpark.html.twig', [
            'controller_name' => 'ParkingController - carpark',
            'user' => $user,
            'carparks' => $carpark,
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
