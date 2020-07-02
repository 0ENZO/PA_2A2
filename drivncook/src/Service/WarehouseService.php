<?php

namespace App\Service;

use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;

class WarehouseService
{
    private $manager;
    private $request;

    // vendor/doctrine/persistence/lib/Doctrine/Persistence/ManagerRegistry.php

    // Le constructeur du service est utile pour inclure d'autre service qu'on aurait besoin ici.
    // Par exemple, $manager et $request, même si, en ce moment où je fais le commit, je ne l'utilise pas
    // Je pourrai l'utiliser (ce que je ferai, je fais juste un commit pour vous montrer comment faire)

    // Note : Ne marche pas encore automatiquement. Il faut mettre ces objets en paramètre quand on appelle la classe, sinon ça foire
    // Il faut voir comment on règle ce pb.
    public function __construct(ObjectManager $manager, Request $request)
    {
        $this->manager = $manager; // Maintenant on peut utiliser toutes les fonctions de manager, comme si on était dans un controller
        $this->$request = $request; // Pareil pour request, qui pourrait faire des opérations sur un formulaire
    }

    // Mettre les fonctions en public pour utiliser cette fonction partout dans n'importe quel controller
    public function sayHello() : string {
        return "Hello friend ! I'm a service ! Now big things are going to change !";
    }

}