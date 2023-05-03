<?php

namespace App\Controller;

use App\Entity\Dish;
use App\Form\DishType;
use App\Repository\DishRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/dish')]
class AdminDishController extends AbstractController
{
    #[Route('/', name: 'app_admin_dish_index', methods: ['GET'])]
    public function index(DishRepository $dishRepository): Response
    {
        return $this->render('admin_dish/index.html.twig', [
            'dishes' => $dishRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_dish_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DishRepository $dishRepository): Response
    {
        $dish = new Dish();
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dishRepository->save($dish, true);

            return $this->redirectToRoute('app_admin_dish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dish/new.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dish_show', methods: ['GET'])]
    public function show(Dish $dish): Response
    {
        return $this->render('admin_dish/show.html.twig', [
            'dish' => $dish,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_dish_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dish $dish, DishRepository $dishRepository): Response
    {
        $form = $this->createForm(DishType::class, $dish);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dishRepository->save($dish, true);

            return $this->redirectToRoute('app_admin_dish_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_dish/edit.html.twig', [
            'dish' => $dish,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_dish_delete', methods: ['POST'])]
    public function delete(Request $request, Dish $dish, DishRepository $dishRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dish->getId(), $request->request->get('_token'))) {
            $dishRepository->remove($dish, true);
        }

        return $this->redirectToRoute('app_admin_dish_index', [], Response::HTTP_SEE_OTHER);
    }
}
