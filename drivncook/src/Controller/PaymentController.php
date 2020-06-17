<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Entity\Franchise;
use App\Entity\User;
use App\Form\CreditCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{

    /**
     * Info : Page de paiement par laquelle doivent passer chaque paiment, peut importe la source et destination.
     * Le Paiement de 50k euros des franchisé est deja pris en compte ultérieurement.l
     * @Route("/", name="payment")
     */
    public function index(Request $request) {

        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $credit_card = new CreditCard();
        $credit_cards = $manager->getRepository(CreditCard::class)->findBy(["franchise" => $user]);

        $customer_form = $this->createForm(CreditCardType::class, $credit_card);
        $customer_form
            ->remove("franchise")
            ->remove("user");

        $customer_form->handleRequest($request);

        if ($customer_form->isSubmitted() and $customer_form->isValid()) {
            // La carte rentré par le client est bonne, il peut maintenant payer avec
            $this->addFlash("succes", "La carte que vous avez rentré est correcte. Vous pouvez maintenant procéder au paiment.");
            return $this->redirectToRoute("payment");   // retour sur la même page, avec les informations de la CB okay.
        }

        // Fausses informations en attendant une vraie commande
        $pre_tax_price = 536.90;
        $tax = $pre_tax_price / 20;     // 20% de taxe, puisqu'on est en France
        $including_taxes_price = $pre_tax_price + $tax;

        $consignee = $manager->getRepository(Franchise::class)->find(rand(0, 9));
        if (!empty($user)) {
            $source = "A Random Customer";
        } else {
            $source = $user;
        }


        return $this->render('payment/index.html.twig', [
           "customer_form" => $customer_form->createView(),
            "credit_cards" => $credit_cards,
            "credit_card" => $credit_card,      // La carte vide, ou bien remplie par le client
            // Envoie des fausses informations
            "pre_tax_price" => $pre_tax_price,
            "tax" => $tax,
            "including_taxes_price" => $including_taxes_price,
            "consignee" => $consignee,
            "source" => $source
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
