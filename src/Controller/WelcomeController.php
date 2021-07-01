<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Client;
use App\Form\ClientFormType;
use App\Form\ContactFormType;
// use Symfony\Component\Mime\Email;
use App\Repository\AdminRepository;
use App\Repository\PricelistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController - Index',
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request): Response
    {   
        $form_contact = $this->createForm(ContactFormType::class);

        //$form_contact->handleRequest($request);

        if ($form_contact->isSubmitted() && $form_contact->isValid()) {

            $contactFormData = $form_contact->getData();

            // Pour rajouter l'envoi de mails
            /*
            $message = (new Email())
            ->from($contactFormData['email'])
            ->to('parkit@mailinator.com')
            ->subject('You\'ve got mail!')
            ->text(
                $contactFormData['message']
            );

            $mailer->send($message);

            return $this->render('welcome/contact.html.twig');
            */
        }
        return $this->render('welcome/contact.html.twig', [
            'controller_name' => 'WelcomeController - Contact',
            'form_contact' => $form_contact->createView(),
        ]);
    }

    /**
     * @Route("/newuser", name="user_new")
     */
    public function newuser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, AdminRepository $adminRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('welcome');
        }

        $client = new Client();
        $user = new Admin;
        $form = $this->createForm(ClientFormType::class, $client);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('identifiant')->getData();
            // on vérifie si le username n'existe pas déjà dans la table admin
            $count = $adminRepository->findBy(['username' => $username]);
            if ($count) {
                $this->addFlash('error', "L'identifiant saisi existe déjà, vous devez en choisir un autre.");
                return $this->redirectToRoute('user_new');
            }
            $pwd = $form->get('password')->getdata();
            $user->setUsername($username);
            $user->setRoles(["ROLE_USER"]);
            $user->setPassword($passwordHasher->hashPassword($user, $pwd));
            $em->persist($client);
            $em->flush();
            $user->setClient($client);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render('welcome/newuser.html.twig', [
            'form_user' => $form->createView(),
        ]);
    }


    /**
     * @Route("/termes", name="termes")
     */
    public function terme(): Response
    {
        return $this->render('welcome/termes.html.twig', [
            'controller_name' => 'WelcomeController - Termes',
        ]);
    }

    /**
     * @Route("/conf", name="confidentialites")
     */
    public function confidentialite(): Response
    {
        return $this->render('welcome/conf.html.twig', [
            'controller_name' => 'WelcomeController - Termes',
        ]);
    }

    /**
     * @Route("/tarif", name="tarif")
     */
    public function tarif(PricelistRepository $pricelistRepository): Response
    {
        return $this->render('welcome/tarif.html.twig', [
            'controller_name' => 'WelcomeController - Tarif',
            'tarifs' => $pricelistRepository->findAll(),
        ]);
    }
}
