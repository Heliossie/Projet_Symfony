<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Client;
use App\Form\ClientFormType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function contact(): Response
    {
        return $this->render('welcome/contact.html.twig', [
            'controller_name' => 'WelcomeController - Contact',
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
    public function tarif(): Response
    {
        return $this->render('welcome/tarif.html.twig', [
            'controller_name' => 'WelcomeController - Tarif',
        ]);
    }
}
