<?php


namespace App\Service;


use App\Entity\Franchise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IdentificationService extends AbstractController
{

    private $manager;

    public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }

    /**
     * @param $id
     * @return bool
     * Description : Vérifie que c'est bien le franchisé connecté qui manage son menu et pas un autre
     */
    public function isTheRightFranchise($id) : bool {
        $franchise = $this->getUser();
        if ($franchise->getId() == $id)
            return true;
        else
            return false;
    }



}