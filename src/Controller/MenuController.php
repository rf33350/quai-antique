<?php

namespace App\Controller;

use App\Entity\Formula;
use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    #[Route('/menus', name: 'menu')]
    public function index(): Response
    {
        $menus = $this->entityManager->getRepository(Menu::class)->findAll();

        $formulas = $this->entityManager->getRepository(Formula::class)->findAll();

        foreach ($formulas as $formula) {
            $datas[] = [
                'formule' => $formula->getTitle(),
                'description' => $formula->getDescription(),
                'prix' => $formula->getPrice(),
                'menu' => $formula->getMenu()->getTitle(),
            ];
        }


        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
            'datas' => $datas,
        ]);
    }
}
