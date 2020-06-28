<?php

namespace App\Controller;

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
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->remove("Role");

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $this->addFlash("primary", "Vos modifications ont bien été pris en compte.");
            return $this->redirectToRoute('customer_profil');
        }

        return $this->render('customer/profil.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
