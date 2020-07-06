<?php


namespace App\Service;


use App\Entity\Franchise;
use App\Entity\FranchiseOrder;
use App\Entity\User;
use App\Entity\UserOrder;
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
        $userOrders = $this->manager->getRepository(UserOrder::class)->findAll();
        $franchises = $this->manager->getRepository(Franchise::class)->findAll();
        $users = $this->manager->getRepository(User::class)->findBy(["role" => 1]);

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

        $nb_user_order = 0;
        $money_user_order = 0;
        foreach ($userOrders as $userOrder) {
            $nb_user_order++;
            $money_user_order += $userOrder->getTotalPrice() * 0.04;
        }

        $sales_revenue = ($nb_franchise * 50000) + ($money_franchise_order) + ($money_user_order);



        $moneyData = [
            "nb_franchise_order" => $nb_franchise_order,
            "money_franchise_order" => $money_franchise_order,
            "nb_franchise" => $nb_franchise,
            "money_enroled_franchise" => $nb_franchise * 50000,
            "nb_user_order" => $nb_user_order,
            "money_user_order" => $money_user_order,
            "sales_revenue" => $sales_revenue
        ];

        return $moneyData;
    }


}