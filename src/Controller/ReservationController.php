<?php

namespace App\Controller;

use App\Entity\Disponibility;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Form\ReservationType;
use App\Repository\DisponibilityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/reservation', name: 'reservation')]
    public function index(Request $request, DisponibilityRepository $disporepo): Response
    {

        $notification = '';
        $notificationDanger = '';

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class,$reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $askedSeats = $form->get('seats')->getData();
            $date = $form->get('date')->getData();
            $service = $form->get('service')->getData();
            $dispo = $disporepo->findOneBy([
                'date' => $date,
                'service' => $service
            ]);
            if ($dispo->getAvailableSeats() > $askedSeats) {
                $restaurant = $this->entityManager->getRepository(Restaurant::class)->findOneById(1);
                $reservation->setRestaurant($restaurant);
                $newValSeats = $dispo->getAvailableSeats() - $askedSeats;
                $dispo->setAvailableSeats($newValSeats);
                $this->entityManager->persist($dispo);
                $this->entityManager->persist($reservation);
                $this->entityManager->flush();

                $session = $request->getSession();
                $session->set('reservation', $reservation);
                return $this->redirectToRoute('reservation_success');
                /*return $this->forward('App\Controller\ReservationSuccessController::index', [
                    'reservation' => $reservation,
                ]);*/
            } else {
                $notificationDanger = 'Il n\'y a plus assez de places pour cette date pour votre réservation';
            }

        }
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'notificationdanger' => $notificationDanger,
        ]);
    }
}
