<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Form\ChangeInfoRestaurantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChangeInfoRestaurantController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/change/info/restaurant', name: 'admin_infos')]
    public function index(Request $request): Response
    {
        $infos = $this->entityManager->getRepository(Restaurant::class)->findOneById(1);

        $form = $this->createForm(ChangeInfoRestaurantType::class, $infos );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newAddress= $form->get('address')->getData();
            $infos->setAddress($newAddress);
            $newSeatNumber= $form->get('seatNumber')->getData();
            $infos->setSeatNumber($newSeatNumber);

            $this->entityManager->persist($infos);
            $this->entityManager->flush();
            $notification = "La mise à jour a été effectuée";
        }else {
            $notification = null;
        }

        return $this->render('admin/admin_info_restaurant.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
        ]);
    }
}
