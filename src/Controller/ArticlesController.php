<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ArticlesController extends AbstractController
{
    #[Route(path: '/articles', name: 'articles', methods: ['GET'])]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('migniau.alexis@gmail.com')
            ->to('migniau.alexis@gmail.com')
            ->subject('Test de MailDev')
            ->text('Ceci est un mail de test');
        $mailer->send($email);

        return new Response("OK");
    }
}
