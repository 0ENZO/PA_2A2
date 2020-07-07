<?php


namespace App\Service;


use App\Entity\FranchiseStock;
use App\Entity\Notify;
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


}