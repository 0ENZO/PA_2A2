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

    /**
     * @Route("/credit-card/new", name="credit_card_add")
     */
    public function credit_card_new(Request $request) {

        $manager = $this->getDoctrine()->getManager();
        $credit_card = new CreditCard();
        $form = $this->createForm(CreditCardType::class, $credit_card);
        $user = $this->getUser();

        // Savoir si celui qui crée sa carte est un franchisé ou un utilisateur
        if ($user instanceof Franchise) {
//            echo "C'est un franchisé !";
            $credit_card->setFranchise($user);
        } elseif ($user instanceof  User) {
//            echo "C'est un client (user)";
            $credit_card->setUser($user);
        } else {
            $this->addFlash("danger", "J'sais pas qui tu es, mais t'es pas sensé être ici ! Dégage !");
        }

        $form
            ->remove("user")
            ->remove("franchise");

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            echo "form envoyé";

            $manager->persist($credit_card);
            $manager->flush();
            echo "objet en bdd";
        }

        return $this->render("payment/credit_card.html.twig", [
            "form" => $form->createView(),
            "user" => $user,
            "credit_card" => $credit_card,
        ]);
    }


}
