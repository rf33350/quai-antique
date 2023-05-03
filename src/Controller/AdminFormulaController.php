<?php

namespace App\Controller;

use App\Entity\Formula;
use App\Form\FormulaType;
use App\Repository\FormulaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formula')]
class AdminFormulaController extends AbstractController
{
    #[Route('/', name: 'app_admin_formula_index', methods: ['GET'])]
    public function index(FormulaRepository $formulaRepository): Response
    {
        return $this->render('admin_formula/index.html.twig', [
            'formulas' => $formulaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_formula_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FormulaRepository $formulaRepository): Response
    {
        $formula = new Formula();
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formulaRepository->save($formula, true);

            return $this->redirectToRoute('app_admin_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_formula/new.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formula_show', methods: ['GET'])]
    public function show(Formula $formula): Response
    {
        return $this->render('admin_formula/show.html.twig', [
            'formula' => $formula,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_formula_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Formula $formula, FormulaRepository $formulaRepository): Response
    {
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formulaRepository->save($formula, true);

            return $this->redirectToRoute('app_admin_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_formula/edit.html.twig', [
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_formula_delete', methods: ['POST'])]
    public function delete(Request $request, Formula $formula, FormulaRepository $formulaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formula->getId(), $request->request->get('_token'))) {
            $formulaRepository->remove($formula, true);
        }

        return $this->redirectToRoute('app_admin_formula_index', [], Response::HTTP_SEE_OTHER);
    }
}
