<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Admin;
use App\Form\CreateAdminFormType;
use App\Form\CreateUserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="app_registration")
     */
    public function registration(Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $user = new Client();
        $admin = new Admin();
        $form1 = $this->createForm(CreateUserFormType::class, $user);
        $form2 = $this->createForm(CreateAdminFormType::class, $admin);

        $form1->handleRequest($request);
        $form2->handleRequest($request);

        dump($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            $entityManagerInterface->persist($user);
            $entityManagerInterface->persist($admin);

            $entityManagerInterface->flush();

            return $this->redirectToRoute('parking');
        }
        dump($request);

        return $this->render('security/registration.html.twig', [
            'form1'=>$form1->createView(),
            'form2' => $form2->createView()
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('welcome');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
