<?php


namespace App\Service;


use App\Entity\FranchiseStock;
use App\Entity\Notify;
use App\Entity\UserOrder;
use Doctrine\ORM\EntityManagerInterface;

class NotifyService
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param $franchise
     * Description : Envoie une notifications pour chaque produit qui sera bientot à cours de stock
     */
    public function hasLowFranchiseStock($franchise) {
        $franchiseStocks = $this->manager->getRepository(FranchiseStock::class)->findBy(["franchise" => $franchise]);

        foreach ($franchiseStocks as $franchiseStock) {

            $notify = false;

            $type = $franchiseStock->getProduct()->getType();
            $quantity = $franchiseStock->getQuantity();
            $product = $franchiseStock->getProduct()->getName();

            if ( ($type == "L" || $type == "Kg") && $quantity < 0.5 )
                $notify = true;
            elseif ($type == "Unit" && $quantity < 25 )
                $notify = true;
            else
                continue;

            if ($notify) {

                $notice = new Notify();
                $notice
                    ->setFranchise($franchise)
                    ->setTitle("Stock faible pour : ".$product)
                    ->setContent("Nous avons détecté que votre sotck de ".$product." commencent à être bas.")
                    ->setBootstrapColor("warning")
                    ->setDate(new \DateTime());
                $this->manager->persist($notice);
                $this->manager->flush();
            }
        }
    }


    /**
     * @param $franchise
     * @param $isActivated
     * Description : Permet de notifier le franchisé lors son activation / désactivation de vente sur le marché
     */
    public function hasSwitchState($franchise, $isActivated) {

        if ($isActivated == 0 ) {
            $title = "Status sur le marché : Désactivé";
            $content = "Vous avez réinitialisé votre menu proposé aux clients.
             Par conséquent, vous n'apparaissez plus dans le marché jusqu'à que vous ne refassiez
             à nouveau votre menu, en acceptant la charte de vente";
            $bootstrap = "danger";
        } else {
            $title = "Status sur le marché : Activé";
            $content = "Vous avez accepté la charte de vente et initialisé votre menu : 
            Vous apparaissez désormais sur le marché !";
            $bootstrap = "success";
        }

        $notice = new Notify();
        $notice
            ->setFranchise($franchise)
            ->setDate(new \DateTime())
            ->setTitle($title)
            ->setContent($content)
            ->setBootstrapColor($bootstrap);
        $this->manager->persist($notice);
        $this->manager->flush();

    }


    /**
     * @param UserOrder $userOrder
     * Description : Informe un franchisé d'un nouvelle commande
     */
    public function hasNewOrder(UserOrder $userOrder) {
        $notice = new Notify();
        $notice
            ->setFranchise($userOrder->getFranchise())
            ->setDate(new \DateTime())
            ->setTitle("Nouvelle commande à effectuer : Commande n°".$notice->getId())
            ->setContent("Nouvelle commande pour ".$userOrder->getUser().".")
            ->setBootstrapColor("success");
        $this->manager->persist($notice);
        $this->manager->flush();
    }

    /**
     * @param UserOrder $userOrder
     * Description : Informe l'utilisateur que sa commande est prête
     */
    public function userOrderReady(UserOrder $userOrder) {
        $notice = new Notify();
        $notice
            ->setUser($userOrder->getUser())
            ->setDate(new \DateTime())
            ->setTitle("Votre commande est prête !")
            ->setContent(
                $userOrder->getFranchise()->getFirstName()." ".
                $userOrder->getFranchise()->getLastName()." A finit de préparer votre commande !"
            )
            ->setBootstrapColor("success");
        $this->manager->persist($notice);
        $this->manager->flush();
    }


    /**
     * @param $franchise
     * Description : Supprimes toutes les notifications d'un franchisé
     */
    public function clearAllNotices($franchise) {
        $notices = $this->manager->getRepository(Notify::class)->findBy(["franchise" => $franchise]);

        foreach ($notices as $notice) {
            $this->manager->remove($notice);
        }
        $this->manager->flush();
    }


    /**
     * @param $franchise
     * @param $id
     * Description : Supprime une notification en particulier d'un franchisé
     */
    public function clearNotice($franchise, $id) {
        $notice = $this->manager->getRepository(Notify::class)->findOneBy(["id" => $id]);
        $this->manager->remove($notice);
        $this->manager->flush();
    }


}