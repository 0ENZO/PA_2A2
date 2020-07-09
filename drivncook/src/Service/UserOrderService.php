<?php


namespace App\Service;


use App\Entity\UserOrder;
use Doctrine\ORM\EntityManagerInterface;

class UserOrderService
{

    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function order_finished(UserOrder $userOrder) {
        $userOrder->setStatus(2);
        $this->manager->flush();
    }


}