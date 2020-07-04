<?php


namespace App\Service;


use App\Entity\Franchise;
use App\Entity\FranchiseOrder;
use Doctrine\ORM\EntityManagerInterface;

class MoneyService
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @return array
     * Description: Retourne toutes les informations monétaire de la société
     * TODO : A compléter pour remplacer les XXX dans le template des récapitulatifs monétaires globaux
     */
    public function getMoneyData() : array {
        $franchiseOrders = $this->manager->getRepository(FranchiseOrder::class)->findAll();
        $franchises = $this->manager->getRepository(Franchise::class)->findAll();

        $nb_franchise_order = 0;
        $money_franchise_order = 0;

        foreach ($franchiseOrders as $franchiseOrder) {
            $nb_franchise_order++;
            $money_franchise_order += $franchiseOrder->getTotalPrice();
        }

        $nb_franchise = 0;

        foreach ($franchises as $franchise) {
            $nb_franchise++;
        }

        $moneyData = [
            "nb_franchise_order" => $nb_franchise_order,
            "money_franchise_order" => $money_franchise_order,
            "nb_franchise" => $nb_franchise,
            "money_enroled_franchise" => $nb_franchise * 50000
        ];

        return $moneyData;
    }


}