<?php

namespace App\Controller;

use App\Entity\CreditCards;
use App\Entity\Franchises;
use App\Form\CreditCardType;
use App\Repository\FranchisesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{
    /**
     * @Route("/process", name="payment_index")
     */
    public function index()
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }

    /**
     * @Route("/credit-card/new", name="credit_card_add")
     */
    public function add_credit_card(Request $request) {

        $manager = $this->getDoctrine()->getManager();

        // Trouver l'objet franchisé connecté
        $franchiseRepo = $manager->getRepository(Franchises::class);
        $user = $this->getUser();
        $user_id = $this->getUser()->getIdFranchise();
        $franchise = $franchiseRepo->find($user_id);

        $credit_card = new CreditCards();
        $credit_card->setFranchises($franchise);

        $form = $this->createForm(CreditCardType::class, $credit_card);
        $form
            ->remove("franchises")
            ->remove("idUser");

        $form->handleRequest($request);


        if ($form->isSubmitted() and $form->isValid()) {
            $manager->persist($credit_card);
            $manager->flush();

            echo "Enregistré !";

            return $this->redirectToRoute("credit_card_add");
        }


        return $this->render("payment/new_credit_card.html.twig", [
            "form" => $form->createView(),
            "user" => $user,
            "user_id" => $user_id,
            "franchise" => $franchise
        ]);
    }
}
