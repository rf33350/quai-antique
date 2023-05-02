<?php

namespace App\Controller;

use App\Entity\OpenHour;
use App\Entity\Restaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/horaires', name: 'schedule')]
    public function index(): Response
    {
        $days = [];
        $infos = [];
        $mourningStartTimes = [];
        $mourningStopTimes = [];
        $eveningStartTimes = [];
        $eveningStopTimes = [];
        $openHours = $this->entityManager->getRepository(OpenHour::class)->findByRelation($this->entityManager->getRepository(Restaurant::class)->findOneById(1));

        foreach ($openHours as $openHour) {
            $days[] = $openHour->getDay();
            $mourningStartTimes[] = $openHour->getMourningStartTime();
            $mourningStopTimes[] = $openHour->getMourningStopTime();
            $eveningStartTimes[] = $openHour->getEveningStartTime();
            $eveningStopTimes[] = $openHour->getEveningStopTime();
        }


        foreach ($days as $key => $day) {
            $infos[$key] = array($day, $mourningStartTimes[$key],$mourningStopTimes[$key], $eveningStartTimes[$key], $eveningStopTimes[$key]);
        }

        return $this->render('schedule/index.html.twig', [
            'infos' => $infos,
        ]);
    }
}
