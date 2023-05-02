<?php

namespace App\Controller;

use App\Entity\Dish;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCardModifyController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/carte/{dish}', name: 'dish')]
    public function index(): Response
    {

        $dish = $this->entityManager->getRepository(Dish::class)->findOneByCategory('plat');
        /*$dishes = $this->entityManager->getRepository(Dish::class)->findAll();*/

        dd($dish);

        return $this->render('admin/admin_card_show.html.twig', [
            'dish' => $dish,
        ]);
    }
}
