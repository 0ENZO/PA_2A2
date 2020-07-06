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

    /**
     * @param array $franchiseOrders
     * @param array $userOrders
     * @return array
     * Description: Retourne les recettes en fonctions des dépenses et rentrées d'agent d'un franchisé
     */
    public function getFranchiseSalesRevenu(array $franchiseOrders, array $userOrders) : array {

        $total_franchise_orders = 0;
        $total_royalties_given = 0;
        $total_gain = 0;

        foreach ($franchiseOrders as $franchiseOrder) {
            $total_franchise_orders += $franchiseOrder->getTotalPrice();
        }

        foreach ($userOrders as $userOrder) {
            $total_royalties_given += $userOrder->getTotalPrice() * 0.04;
            $total_gain += $userOrder->getTotalPrice() - ($userOrder->getTotalPrice() * 0.04);
        }

        $franchiseMoneyData = [
            "total_franchise_orders" => $total_franchise_orders,
            "total_royalties_given" => $total_royalties_given,
            "total_gain" => $total_gain,
            "total" => $total_gain - ($total_franchise_orders + $total_royalties_given)
        ];

        return $franchiseMoneyData;


    }


}