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
     * Description: Vérifie que c'est bien le franchisé connecté qui manage son menu et pas un autre
     *              Permet d'accéder à un autre profil franchisé en passant par l'url comme un petit filou
     */
    public function isTheRightFranchise($id) : bool {
        $franchise = $this->getUser();
        if ($franchise->getId() == $id)
            return true;
        else
            return false;
    }


    /**
     * @param $id
     * @return bool
     * Description: Vérifie que c'est bien le bon user qui est sur la page, pour emêcher un petit filou de se balader avec l'url
     */
    public function isTheRightUser($id) : bool {
        $user = $this->getUser();
        if ($user->getId() == $id)
            return true;
        else
            return false;
    }


    /**
     * @param $user
     * @return bool
     * Description: Vérifie que l'user, est bien un admin ou non.
     */
    public function isAdmin($user) : bool {
        $role = $user->getRole()->getName();
        if ($role != "Admin")
            return false;
        else
            return true;
    }



}