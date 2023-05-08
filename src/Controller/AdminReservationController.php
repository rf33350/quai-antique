<?php

namespace App\Controller;

use App\Classe\BookMail;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Form\Reservation1Type;
use App\Form\SortReservationType;
use App\Repository\DisponibilityRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/reservation')]
class AdminReservationController extends AbstractController
{
    #[Route('/', name: 'app_admin_reservation_index', methods: ['GET', 'POST'])]
    public function index(ReservationRepository $reservationRepository, Request $request): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(SortReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->get('date')->getData();
            $reservations = $reservationRepository->findBy(
                ['date' => $date],
                ['service' => 'ASC']
            );

        } else {
            $reservations = $reservationRepository->findAll();
        }


        return $this->render('admin_reservation/index.html.twig', [
            'reservations' => $reservations,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_admin_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationRepository $reservationRepository): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(Reservation1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationRepository->save($reservation, true);

            return $this->redirectToRoute('app_admin_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_reservation_show', methods: ['GET'])]
    public function show(Reservation $reservation): Response
    {
        return $this->render('admin_reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reservation $reservation, ReservationRepository $reservationRepository,DisponibilityRepository $disporepo, RestaurantRepository $restau): Response
    {
        $notificationDanger = null;
        $formerNbSeats = $reservation->getSeats();

        $form = $this->createForm(Reservation1Type::class, $reservation);
        $form->handleRequest($request);

        $date = $reservation->getDate();
        $service = $reservation->getService();

        $dispo = $disporepo->findOneBy([
            'date' => $date,
            'service' => $service
        ]);

        if ($form->isSubmitted() && $form->isValid()) {
            $seatsAvailable = $dispo->getAvailableSeats() + $formerNbSeats;

            $newNbSeats = $form->get('seats')->getData();

            if ($seatsAvailable >= $newNbSeats) {
                $newValSeats = $seatsAvailable - $newNbSeats;
                $dispo->setAvailableSeats($newValSeats);
                $disporepo->save($dispo);

                $restaurant = $restau->findOneById(1);
                $reservation->setRestaurant($restaurant);
                $reservationRepository->save($reservation, true);

            } else {
                $notificationDanger = 'Il n\'y a plus assez de places pour cette date pour modifier la réservation';
                return $this->redirectToRoute('app_admin_reservation_edit', ['notificationDanger'=> $notificationDanger]);
            }

            return $this->redirectToRoute('app_admin_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'notificationDanger'=> $notificationDanger,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, Reservation $reservation, ReservationRepository $reservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $reservationRepository->remove($reservation, true);
        }

        return $this->redirectToRoute('app_admin_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
