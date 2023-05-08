<?php

namespace App\Controller;

use App\Classe\ContactMail;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {

        $mail = new ContactMail();
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);
        if ($this->getUser()) {
            $form->get('FirstName')->setData($this->getUser()->getFirstName());
            $form->get('LastName')->setData($this->getUser()->getLastName());
            $form->get('email')->setData($this->getUser()->getEmail());
        }


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $manager->persist($contact);
            $manager->flush();
            $firstName = $contact->getFirstName();
            $lastName = $contact->getLastName();
            $subject = $contact->getSubject();
            $message = $contact->getText();
            $email = $contact->getEmail();

            $mail->send($firstName, $lastName, $email, $subject, $message);

            $this->addFlash(
                'success',
                'Le message a bien été transmis'
            );
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
