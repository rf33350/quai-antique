<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $dishes = $this->entityManager->getRepository(Dish::class)->findAll();

        foreach ($dishes as $dish) {
            if($dish->isIsStar()) {
                $dishStars[] = $dish;
            }
        }

        return $this->render('home/index.html.twig', [
            'dishes' => $dishStars,
        ]);
    }
}
