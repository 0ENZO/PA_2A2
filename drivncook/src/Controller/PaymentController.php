<?php

namespace App\Controller;

use App\Entity\CreditCard;
use App\Entity\Franchise;
use App\Entity\User;
use App\Entity\Warehouse;
use App\Form\CreditCardType;
use App\Repository\FranchiseRepository;
use App\Repository\WarehouseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/payment")
 */
class PaymentController extends AbstractController
{

    /**
     * Info : Page de paiement par laquelle doivent passer chaque paiment, peut importe la source et destination.
     * Le Paiement de 50k euros des franchisé est deja pris en compte ultérieurement.l
     * @Route("/{selected_credit_card}", name="payment_process")
     */
    public function index(Request $request, Session $session, $selected_credit_card = null, WarehouseRepository $warehouseRepository, FranchiseRepository $franchiseRepository) {
        // TODO ATTENTION. Rien n'est sécurisé ici. L'id de la final_cb passe tout le temps en GET. J'ai pas trouvé d'autres moyen pour le moment
        // TODO ATTENTION. Il va falloir aussi veiller à encoder les informations sensibles (informations bancaires nottement)
        // TODO ATTENTION. A terme, remplacer toutes les fausses valeurs par des vraies

        $manager = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        if (!empty($user) and $user->getRoles()[0] === "ROLE_ADMIN") {
            $this->addFlash("warning", "<p>Vous êtes Administrateur.</p><p>Pour voir ce qui appareitra réellement, il faut prendre un compte d'un autre rôle, ou pas de compte.</p>");
        }

        $credit_card = new CreditCard();

        if ($this->getUser() instanceof User){
            $credit_cards = $manager->getRepository(CreditCard::class)->findBy(["user" => $user]);

        } elseif ( $this->getUser() instanceof Franchise) {
            $credit_cards = $manager->getRepository(CreditCard::class)->findBy(["franchise" => $user]);
        }

        if (!empty($selected_credit_card) || $selected_credit_card != null) {
            $selected_credit_card = $manager->getRepository(CreditCard::class)->find($selected_credit_card);
            $this->addFlash("success", "La carte que vous avez rentré est correcte. Vous pouvez maintenant procéder au paiment.");
        }

        $customer_form = $this->createForm(CreditCardType::class, $credit_card);
        $customer_form
            ->remove("franchise")
            ->remove("user");

        $customer_form->handleRequest($request);

        if ($customer_form->isSubmitted() and $customer_form->isValid()) {
            // La carte rentré par le client est bonne, il peut maintenant payer avec
            // Créer une variable $final_card pour savoir avec quelle carte le client doit payer
            $selected_credit_card = $credit_card;
            $this->addFlash("success", "La carte que vous avez rentré est correcte. Vous pouvez maintenant procéder au paiment.");
        } elseif ($customer_form->isSubmitted() and !($customer_form->isValid())) {
            $this->addFlash("danger", "Il semble que les informations que vous avez rentrées sont incorrectes. Veuillez réessayer.");
        }

        // Fausses informations en attendant une vraie commande

        $totalTTC = $session->get('cart_totalTTC');
        $totalHT = $session->get('cart_totalHT');
        
        if ($user instanceof Franchise) {
            $consignee = $warehouseRepository->findOneById($session->get('cart_warehouse'));
        } else {
            $consignee = $franchiseRepository->findOneById($session->get('cart_franchise'));
        }

        if (empty($user)) {
            // TODO : A peaufiner pour clients anonymes
            $source = "A Random Customer";
        } else {
            $source = $user;
        }

        return $this->render('payment/index.html.twig', [
           "customer_form" => $customer_form->createView(),
            "credit_cards" => $credit_cards,
            "credit_card" => $credit_card,      // La carte vide, ou bien remplie par le client
            // Envoie des fausses informations
            "totalTTC" => $totalTTC,
            "totalHT" => $totalHT,
            "consignee" => $consignee,
            "source" => $source,
            "user" => $user,
            "selected_credit_card" => $selected_credit_card, 
        ]);
    }

    /**
     * @Route("/payment/success", name="payment_success")
     */
    public function payment_success() {
        return $this->render("payment/payment_success.html.twig");
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
            if ($user instanceof Franchise) {
                return $this->redirectToRoute("franchise_profil");
            } elseif ($user instanceof  User) {
                return $this->redirectToRoute("user_profil");
            }

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
        $user = $this->getUser();
        $credit_card = $manager->getRepository(CreditCard::class)->find($id);
        $form = $this->createForm(CreditCardType::class, $credit_card);

        $form
            ->remove("franchise")
            ->remove("user");

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();

            $this->addFlash("primary", "Vous avez modifié vos informations relatives à vos moyens de paiement.");

            if ($user instanceof Franchise) {
                return $this->redirectToRoute("franchise_profil");
            } elseif ($user instanceof  User) {
                return $this->redirectToRoute("user_profil");
            }

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
        $user = $this->getUser();
        $credit_card = $manager->getRepository(CreditCard::class)->find($id);
        $manager->remove($credit_card);
        $manager->flush();

        $this->addFlash("danger", "Vous avez supprimé un moyen de paiement.");
        if ($user instanceof Franchise) {
            return $this->redirectToRoute("franchise_profil");
        } elseif ($user instanceof  User) {
            return $this->redirectToRoute("user_profil");
        }
    }

}
