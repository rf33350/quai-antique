<?php

namespace App\Controller;

use App\Entity\Disponibility;
use App\Form\DisponibilityListType;
use App\Form\DisponibilityType;
use App\Repository\DisponibilityRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dispo')]
class AdminDispoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_admin_dispo_index', methods: ['GET'])]
    public function index(DisponibilityRepository $disponibilityRepository): Response
    {
        return $this->render('admin_dispo/index.html.twig', [
            'disponibilities' => $disponibilityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_dispo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DisponibilityRepository $disponibilityRepository, RestaurantRepository $restaurantRepo): Response
    {
        $disponibility = new Disponibility();
        $form = $this->createForm(DisponibilityType::class, $disponibility);
        $form->handleRequest($request);
        /*$restaurant = $restaurantRepo->findOneById(1);
        $seats = $restaurant->getSeatNumber();
        $form->get('availableSeats')->setData($seats);*/

        if ($form->isSubmitted() && $form->isValid()) {
            $disponibilityRepository->save($disponibility, true);

            return $this->redirectToRoute('app_admin_dispo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dispo/new.html.twig', [
            'disponibility' => $disponibility,
            'form' => $form,
        ]);
    }

    #[Route('/new/multiple', name: 'app_admin_dispo_new_multiple', methods: ['GET', 'POST'])]
    public function multiple(Request $request, ): Response
    {
        $disponibility = new Disponibility();
        $form = $this->createForm(DisponibilityListType::class, $disponibility);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $services = ['midi', 'soir'];
            $seats = $form->get('availableSeats')->getData();
            $startDate = $form->get('date-debut')->getData();
            $restaurant = $form->get('restaurant')->getData();
            $endDate = $form->get('date-fin')->getData();
            $endDate->modify('+1 day');
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($startDate, $interval, $endDate);
            // Boucle pour créer des disponibilités pour chaque jour de la période
            foreach ($period as $day) {
                if ($day->format('w') == 3) { // mercredi
                    continue; // passer au jour suivant sans rien enregistrer
                } elseif ($day->format('w') == 6) { // samedi
                    $disponibility = new Disponibility();
                    $disponibility->setDate($day);
                    $disponibility->setAvailableSeats($seats);
                    $disponibility->setService('soir');
                    $disponibility->setRestaurant($restaurant);
                    $this->entityManager->persist($disponibility);
                    $this->entityManager->flush();
                } elseif ($day->format('w') == 0) { // dimanche
                    $disponibility = new Disponibility();
                    $disponibility->setDate($day);
                    $disponibility->setAvailableSeats($seats);
                    $disponibility->setService('midi');
                    $disponibility->setRestaurant($restaurant);
                    $this->entityManager->persist($disponibility);
                    $this->entityManager->flush();
                } else { // autres jours
                    foreach ($services as $service) {
                        $disponibility = new Disponibility();
                        $disponibility->setDate($day);
                        $disponibility->setAvailableSeats($seats);
                        $disponibility->setService($service);
                        $disponibility->setRestaurant($restaurant);
                        $this->entityManager->persist($disponibility);
                        $this->entityManager->flush();
                    }
                }
            }

            return $this->redirectToRoute('app_admin_dispo_index', [], Response::HTTP_SEE_OTHER);

        }
        return $this->renderForm('admin_dispo/newlist.html.twig', [
            'disponibility' => $disponibility,
            'form' => $form,
        ]);

    }

    #[Route('/{id}', name: 'app_admin_dispo_show', methods: ['GET'])]
    public function show(Disponibility $disponibility): Response
    {
        return $this->render('admin_dispo/show.html.twig', [
            'disponibility' => $disponibility,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_dispo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Disponibility $disponibility, DisponibilityRepository $disponibilityRepository): Response
    {
        $form = $this->createForm(DisponibilityType::class, $disponibility);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $disponibilityRepository->save($disponibility, true);

            return $this->redirectToRoute('app_admin_dispo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dispo/edit.html.twig', [
            'disponibility' => $disponibility,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dispo_delete', methods: ['POST'])]
    public function delete(Request $request, Disponibility $disponibility, DisponibilityRepository $disponibilityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$disponibility->getId(), $request->request->get('_token'))) {
            $disponibilityRepository->remove($disponibility, true);
        }

        return $this->redirectToRoute('app_admin_dispo_index', [], Response::HTTP_SEE_OTHER);
    }
}
