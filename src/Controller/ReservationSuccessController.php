<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationSuccessController extends AbstractController
{
    #[Route('/reservation/success', name: 'reservation_success')]
    public function index(Request $request): Response
    {

        $session = $request->getSession();
        $reservation = $session->get('reservation');

        return $this->render('reservation/success.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}
