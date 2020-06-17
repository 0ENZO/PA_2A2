<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Entity\Franchise;
use App\Entity\User;
use App\Form\CreditCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{

    /**
     * @Route("/", name="payment")
     */
    public function index() {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }


    // CARTE BANCAIRE

    /**
     * @Route("/credit-card/new", name="credit_card_add")
     */
    public function credit_card_new(Request $request) {

        $manager = $this->getDoctrine()->getManager();
        $credit_card = new CreditCard();
        $form = $this->createForm(CreditCardType::class, $credit_card);
        $user = $this->getUser();

        // Savoir si celui qui créer sa carte est un franchisé ou un utilisateur
        if ($user instanceof Franchise) {
            $credit_card->setFranchise($user);
        } elseif ($user instanceof  User) {
            $credit_card->setUser($user);
        } else {
            $this->addFlash("danger", "Erreur d'identitifcation");
            $this->redirectToRoute("home");
        }

        $form
            ->remove("user")
            ->remove("franchise");

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $manager->persist($credit_card);
            $manager->flush();

            $this->addFlash("success", "Vous avez ajouté un nouveau moyen de paiement.");
            return $this->redirectToRoute("franchise_profil");
        }

        return $this->render("payment/credit_card.html.twig", [
            "form" => $form->createView(),
            "credit_card" => $credit_card,
        ]);
    }


    /**
     * @Route("/credit-card/edit/{id}", name="credit_card_edit")
     */
    public function credit_card_edit($id, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $credit_card = $manager->getRepository(CreditCard::class)->find($id);
        $form = $this->createForm(CreditCardType::class, $credit_card);

        $form
            ->remove("franchise")
            ->remove("user");

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();

            $this->addFlash("primary", "Vous avez modifié vos informations relatives à vos moyens de paiement.");
            return $this->redirectToRoute("franchise_profil");
        }

        return $this->render("payment/credit_card.html.twig", [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/credit-card/delete/{id}", name="credit_card_delete")
     */
    public function credit_card_delete($id, Request $request) {
        $manager = $this->getDoctrine()->getManager();
        $credit_card = $manager->getRepository(CreditCard::class)->find($id);
        $manager->remove($credit_card);
        $manager->flush();

        $this->addFlash("danger", "Vous avez supprimé un moyen de paiement.");
        return $this->redirectToRoute("franchise_profil");
    }

}
