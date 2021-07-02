<?php

namespace App\Controller;

use App\Entity\Carpark;
use App\Entity\Invoice;
use App\Form\UserEditFormType;
use App\Form\ClientEditFormType;
use App\Repository\CarparkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ParkingRepository;
use App\Repository\PricelistRepository;
use App\Repository\SubscriptionPriceRepository;
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
    public function index(CarparkRepository $carparkRepository, SubscriptionPriceRepository $subscriptionPriceRepository): Response
    {
        $user = $this->getUser();
        $client = $user->getClient();
        $carpark_active = $carparkRepository->findOneBy(['client' => $client, 'departure' => null]);

        // liste des stationnements de l'user
        $carparks = $carparkRepository->findBy(['client' => $client], ['invoice' => 'DESC']);

        $tab_carpark = [];
        $tab_invoice = [];

        // liste des factures de l'user
        foreach ($carparks as $carpark) {
            if ($carpark->getInvoice() != null) {
                array_push($tab_carpark, $carpark);
            }
        }

        for ($i = 0; $i <= count($tab_carpark) - 1; $i++) {
            $invoice = $tab_carpark[$i]->getInvoice();
            if ($i == 0) {
                array_push($tab_invoice, $invoice);
            }
            if ($i > 0 && $tab_carpark[$i]->getInvoice() != $tab_carpark[$i - 1]->getInvoice()) {
                array_push($tab_invoice, $invoice);
            }
        }

        $subscription = $subscriptionPriceRepository->findOneBySomeField(new \DateTime());
        $subscription_price = $subscription->getAmountSub();

        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController - Espace Client',

            'user' => $user,
            'carpark' => $carpark_active,
            'invoices' => $tab_invoice[0],
            'subscription_price' => $subscription_price,
        ]);
    }

    /**
     * @Route("/user/invoice", name="user_invoice")
     */
    public function invoice(CarparkRepository $carparkRepository, SubscriptionPriceRepository $subscriptionPriceRepository): Response
    {

        // récupération les objets
        $user = $this->getUser();
        $client = $user->getClient();

        // liste des stationnements de l'user
        $carparks = $carparkRepository->findBy(['client' => $client], ['invoice' => 'DESC']);

        $tab_carpark = [];
        $tab_invoice = [];

        // liste des factures de l'user
        foreach ($carparks as $carpark) {
            if ($carpark->getInvoice() != null) {
                array_push($tab_carpark, $carpark);
            }
        }

        // on évite la redondance de factures
        for($i = 0; $i<= count($tab_carpark)-1; $i++)
        {
            $invoice=$tab_carpark[$i]->getInvoice();
            if($i==0)
            {
                array_push($tab_invoice, $invoice);
            }
            if ($i > 0 && $tab_carpark[$i]->getInvoice() != $tab_carpark[$i - 1]->getInvoice()) {
                array_push($tab_invoice, $invoice);
            }
        }

        // on récupére le montant de l'abonnement mensuel en vigueur
        $subscription = $subscriptionPriceRepository->findOneBySomeField(new \DateTime());
        $subscription_price = $subscription->getAmountSub();

        return $this->render('client/invoice.html.twig', [
            'controller_name' => 'ClientController - Factures',
            'user' => $user,
            'invoices' => $tab_invoice,
            'subscription_price' => $subscription_price,
        ]);
    }

    /**
     * @Route("/user/invoice/{id}", name="user_invoice_current")
     */
    public function currentInvoice($id, CarparkRepository $carparkRepository, PricelistRepository $pricelistRepository, SubscriptionPriceRepository $subscriptionPriceRepository, EntityManagerInterface $em): Response
    {
        if (!$carparkRepository->findOneBy(['id' => $id, 'departure' => null])) {
            return $this->redirectToRoute('user_invoice');
        }

        // récupération des objets
        $user = $this->getUser();
        $client = $user->getClient();
        $carpark = $carparkRepository->findOneBy(['id' => $id]);
        
        // calcul de la durée de stationnement
        $arrival_date = $carpark->getArrival();
        $departure_date = new \DateTime();
        $carpark->setDeparture($departure_date);

        // $carpark_exist = $carparkRepository->findOneBy(['id' => $id]);
        $duration = $arrival_date->diff($departure_date);
        $duration = $duration->format('%H:%I:%S');
        
        // récupération du prix en fonction de la durée
        $query = $pricelistRepository->findByPrice($duration);

        $price=$query[0]->getPrice();
        $carpark->setPrice($price);

        // !! invoice ne sera prise en compte qu'au moment de la date de sortie du parking !!
        // On détermine si le client a déjà stationné dans le mois en cours
        $current_month = $departure_date->format('n');
        $current_year = $departure_date->format('Y');
        $current_carparks = $carparkRepository->monthlyCarparks($current_month, $current_year, $client);

        // si déjà des stationnements dans le mois
        if ($current_carparks) {
            // on récupére un des enregistrements pour avoir l'id et la date de facture
            $invoice = $current_carparks[0]->getInvoice();
            // on incrémente son montant
            $montant = $invoice->getAmount();
            $montant += $price;
            $invoice->setAmount($montant);
        }
        // si c'est le 1er stationnement du mois
        else {
            $invoice = new Invoice();
            $year = $departure_date->format('Y');
            $month = $departure_date->format('n');
            $date_invoice = date('Y-m-d', mktime(0, 0, 0, $month + 1, 1, $year));
            $date_invoice = new \DateTime($date_invoice);
            $invoice->setDate($date_invoice);
            $invoice->setAmount($price);
        }

        // on finalise l'objet invoice (facture) créé en BD
        $invoice->addCarpark($carpark);
        $em->persist($invoice);
        $em->flush();

        // on finalise l'objet carpark (stationnement) créé en BD
        $carpark->setInvoice($invoice);
        $em->persist($carpark);
        $em->flush();

        // liste des stationnements de l'user
        $carparks = $carparkRepository->findBy(['client' => $client], ['invoice' => 'DESC']);

        $tab_carpark = [];
        $tab_invoice = [];

        // liste des factures de l'user
        foreach ($carparks as $carpark) {
            if ($carpark->getInvoice() != null) {
                array_push($tab_carpark, $carpark);
            }
        }

        // on évite la redondance de factures
        for($i = 0; $i<= count($tab_carpark)-1; $i++)
        {
            $invoice=$tab_carpark[$i]->getInvoice();
            if($i==0)
            {
                array_push($tab_invoice, $invoice);
            }
            if ($i > 0 && $tab_carpark[$i]->getInvoice() != $tab_carpark[$i - 1]->getInvoice()) {
                array_push($tab_invoice, $invoice);
            }
        }
        
        // on récupére le montant de l'abonnement mensuel en vigueur
        $subscription = $subscriptionPriceRepository->findOneBySomeField(new \DateTime());
        $subscription_price = $subscription->getAmountSub();

        $this->addFlash('success', "Votre stationnement à bien était facturé");

        return $this->render('client/invoice.html.twig', [
            'controller_name' => 'ClientController - Factures',
            'user' => $user,
            'carpark' => $carpark,
            'invoice' => $invoice,
            'invoices' => $tab_invoice,
            'duration' => $duration,
            'price' => $price,
            'subscription_price' => $subscription_price,
        ]);
    }

    /**
     * @Route("/user/carpark", name="user_parking")
     */
    public function parking(CarparkRepository $carparkRepository, ParkingRepository $parkingRepository): Response
    {
        // récupération des objets
        $user = $this->getUser();
        $client = $user->getClient();
        // on vérifie que pour l'user connecté, s'il a déjà un stationnement en cours
        $carparks = $carparkRepository->findOneBy(['client' => $client, 'departure' => null]);


        return $this->render('parking/carpark.html.twig', [
            'controller_name' => 'ParkingController - carpark',
            'user' => $user,
            'carparks' => $carparks,
            'parkings' => $parkingRepository->findAll(),
        ]);
    }


    /**
     * @Route("/user/carpark/{id}",name="user_carpark")
     */
    public function carpark($id, ParkingRepository $parkingRepository, EntityManagerInterface $em): Response
    {
        // récupération des objets
        $user = $this->getUser();
        $client = $user->getClient();
        $parking = $parkingRepository->findOneBy(['id' => $id]);
        // création du stationnement dans le parking sélectionné
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
            $this->addFlash('success', "Votre compte à bien était modifié");
            return $this->redirectToRoute('user');
        }

        if ($form_user->isSubmitted() && $form_user->isValid()) {
            //Modification des données user
            $pwd = $form_user->get('password')->getdata();
            $user->setPassword($passwordHasher->hashPassword($user, $pwd));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "Votre mot de passe à bien était modifié");
            return $this->redirectToRoute('user');
        }

        return $this->render('client/edit.html.twig', [
            'user' => $user,
            'form_client' => $form_client->createView(),
            'form_user' => $form_user->createView(),
        ]);
    }
}
