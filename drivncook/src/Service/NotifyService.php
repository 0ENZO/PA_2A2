<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class NotifyService
{

    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    


}