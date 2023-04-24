<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/horaires', name: 'schedule')]
    public function index(): Response
    {
        return $this->render('schedule/index.html.twig');
    }
}
