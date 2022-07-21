<?php

namespace App\Controller;

use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;



#[Route('/home', name: 'app_')]
class HomeController extends AbstractController
{


    #[Route('/', name: 'home')]
    public function index(Mailer $mailer): Response
    {

        try {
            $mailer->send();
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
            echo $e->getMessage();
        }


        return $this->render('home/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
