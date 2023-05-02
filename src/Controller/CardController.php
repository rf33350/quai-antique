<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/carte', name: 'card')]
    public function index(): Response
    {
        $dishes = $this->entityManager->getRepository(Dish::class)->findAll();

        return $this->render('card/index.html.twig', [
            'dishes' => $dishes,
        ]);
    }
}
