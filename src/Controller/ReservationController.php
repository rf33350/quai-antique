<?php

namespace App\Controller;

use App\Classe\BookMail;
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

        $errorMessage = null;
        $notificationDanger = '';

        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class,$reservation);

        if ($this->getUser()) {
            $form->get('firstName')->setData($this->getUser()->getFirstName());
            $form->get('lastName')->setData($this->getUser()->getLastName());
            $form->get('email')->setData($this->getUser()->getEmail());
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstName = $form->get('firstName')->getData();
            $lastName = $form->get('lastName')->getData();
            $email = $form->get('email')->getData();
            $askedSeats = $form->get('seats')->getData();
            $date = $form->get('date')->getData();
            $hour = $form->get('arrivalHour')->getData();
            $arrivalHour = \DateTime::createFromFormat('H:i:s',$hour);
            $service = $form->get('service')->getData();
            try {
                // code pour trouver la disponibilité
                $dispo = $disporepo->findOneBy([
                    'date' => $date,
                    'service' => $service
                ]);

                // vérification si la disponibilité a été trouvée
                if (!$dispo) {
                    throw new \Exception("Vous ne pouvez pas réserver à cette date/horaire");
                }
                if ($dispo->getAvailableSeats() > $askedSeats) {
                    $mail = new BookMail();
                    $restaurant = $this->entityManager->getRepository(Restaurant::class)->findOneById(1);
                    $reservation->setArrivalHour($arrivalHour);
                    $reservation->setRestaurant($restaurant);
                    $newValSeats = $dispo->getAvailableSeats() - $askedSeats;
                    $dispo->setAvailableSeats($newValSeats);
                    $this->entityManager->persist($dispo);
                    $this->entityManager->persist($reservation);
                    $this->entityManager->flush();

                    $dateString = $date->format('d-m-Y');
                    $seatsString = strval($askedSeats);

                    $mail->send($firstName, $lastName, $dateString, $hour, $seatsString, $email);
                    $session = $request->getSession();
                    $session->set('reservation', $reservation);
                    return $this->redirectToRoute('reservation_success');

                } else {
                    $notificationDanger = 'Il n\'y a plus assez de places pour cette date pour votre réservation';
                }
            } catch (\Exception $e) {
                $errorMessage = $e->getMessage();
            }
        }
        return $this->render('reservation/index.html.twig', [
            'form' => $form->createView(),
            'errorMessage' => $errorMessage,
            'notificationdanger' => $notificationDanger,
        ]);
    }
}
