<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function show()
    {
        return $this->render('page/about.html.twig');
    }

    /**
     * @Route("/contacter", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->remove('lastName');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mail = $form->get('email')->getData();
            // $firstName = $form->get('firstName')->getData();
            $message = $form->get('message')->getData();

            $email = (new \Swift_Message())
                ->setSubject('Nouveau message')
                ->setFrom('drivn.cook.equipe@gmail.com')
                ->setTo($mail)
                ->setBcc('drivn.cook.equipe@gmail.com')
                ->setBody($message)
            ;   
            $mailer->send($email);

            $this->addFlash("success", "Votre message a été envoyé");
        }

        return $this->render('page/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
