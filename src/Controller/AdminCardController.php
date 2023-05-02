<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminCardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/carte', name: 'admin_card')]
    public function index(): Response
    {
        $dishes = $this->entityManager->getRepository(Dish::class)->findAll();


        return $this->render('admin/admin_card_list.html.twig', [
            'dishes' => $dishes,
        ]);
    }

}
