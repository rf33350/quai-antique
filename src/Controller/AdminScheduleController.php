<?php

namespace App\Controller;


use App\Entity\OpenHour;
use App\Entity\Restaurant;
use App\Form\ChangeScheduleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminScheduleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/schedule', name: 'admin_schedule')]
    public function index(): Response
    {
        $days = [];
        $openHours = $this->entityManager->getRepository(OpenHour::class)->findByRelation($this->entityManager->getRepository(Restaurant::class)->findOneById(1));

        foreach ($openHours as $openHour) {
            $days[] = $openHour->getDay();
        }

        return $this->render('admin/admin_schedule.html.twig', [
            'days' => $days,
        ]);
    }

    #[Route('/admin/schedule/{day}', name: 'day')]
    public function show($day, Request $request): Response
    {
        $chosenday = $this->entityManager->getRepository(OpenHour::class)->findOneByDay($day);
        $dayName = $chosenday->getDay();

        $form = $this->createForm(ChangeScheduleType::class, $chosenday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mourningStartTimeModified = $form->get('mourningStartTime')->getData();
            $chosenday->setMourningStartTime($mourningStartTimeModified);
            $mourningStopTimeModified = $form->get('mourningStopTime')->getData();
            $chosenday->setMourningStopTime($mourningStopTimeModified);
            $eveningStartTimeModified = $form->get('eveningStartTime')->getData();
            $chosenday->setEveningStartTime($eveningStartTimeModified);
            $eveningStopTimeModified = $form->get('eveningStopTime')->getData();
            $chosenday->setEveningStopTime($eveningStopTimeModified);
            $this->entityManager->persist($chosenday);
            $this->entityManager->flush();
                $notification = "La mise à jour a été effectuée";
            }else {
                $notification = null;
            }

        if(!$chosenday) {
            return $this->redirectToRoute('/admin/schedule');
        }

        return $this->render('admin/admin_schedule_show.html.twig', [
            'day' =>  $dayName,
            'form' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}
