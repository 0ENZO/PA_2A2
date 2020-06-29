<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class CustomerController extends AbstractController
{
    /**
     * @Route("/profil", name="customer_profil")
     */
    public function customer_profil(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $credit_cards = $manager->getRepository(CreditCard::class)->findBy(["user" => $user]);



        $form = $this->createForm(UserType::class, $user);
        $form->remove("Role");

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();
            $this->addFlash("primary", "Vos modifications ont bien été pris en compte.");
            return $this->redirectToRoute('customer_profil');
        }

        return $this->render('customer/profil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'credit_cards' =>$credit_cards
        ]);
    }
}
