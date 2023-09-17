<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'dashboard:login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Redirection si déja connecté
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'page_title' => 'Notflix - Dashboard',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('dashboard'),
            'username_label' => 'Username',
            'password_label' => 'Password',
            'sign_in_label' => 'Log in',
        ]);
    }

    #[Route(path: '/logout', name: 'dashboard:logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
