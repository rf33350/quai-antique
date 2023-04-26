<?php

namespace App\Controller;

use App\Form\ChangeMessageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountMessageController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/modifier-message', name: 'account_message')]
    public function index(Request $request): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangeMessageType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new_message = $form->get('allergy')->getData();
            $user->setAllergy($new_message);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $notification = "Vos informations ont bien été mises à jour";
        }
        return $this->render('account/message.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}
