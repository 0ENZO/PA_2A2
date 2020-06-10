<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\MaxCapacities;
use App\Entity\Roles;
use App\Entity\Trucks;
use App\Entity\Users;

use App\Entity\Cities;
use App\Entity\Addresses;
use App\Entity\Franchises;
use App\Entity\Departments;
use App\Entity\Warehouses;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {



        // Création des rôles client / franchise / admin

        $role_client = new Roles();
        $role_client->setName('Client');
        $manager->persist($role_client);

        $role_franchise = new Roles();
        $role_franchise->setName('Franchise');
        $manager->persist($role_franchise);

        $role_admin = new Roles();
        $role_admin->setName('Admin');
        $manager->persist($role_admin);






        // Création adresse

        // Départements

        $department = new Departments();
        $department->setName('Ile de France');
        $manager->persist($department);

        // Villes

        $city = new Cities();
        $city->setName('Creteil');
        $city->setPostalNumber('94000');
        $city->setIdDepartment($department);
        $manager->persist($city);

        $city2 = new Cities();
        $city2
            ->setName("Paris")
            ->setIdDepartment($department)
            ->setPostalNumber("75000");
        $manager->persist($city2);

        // Adresse finale (ville + département + rue)

        $address = new Addresses();
        $address->setStreet('Avenue de la france libre');
        $address->setNumber('1');
        $address->setIdCity($city);
        $manager->persist($address);

        $address_warehouse = new Addresses();
        $address_warehouse
            ->setStreet("Rue de vendeaume")
            ->setNumber("42")
            ->setIdCity($city2);
        $manager->persist($address_warehouse);






        // Création des premiers users : Client et Admin

        $client = new Users();
        $client->setIdRole($role_client);
        $client->setPseudo('Client_lambda');
        $client->setFirstName('Lee');
        $client->setLastName('Sin');
        $client->setEmail('client@drivncook.fr');
        $client->setBirthDate(new \DateTime());
        $client->setPassword($this->passwordEncoder->encodePassword(
            $client,
            'azerty'
        ));
        $client->setIsActivated(true);
        $manager->persist($client);

        $admin = new Users();
        $admin->setIdRole($role_admin);
        $admin->setFirstName('Prenom');
        $admin->setLastName('Nom');
        $admin->setPseudo('Admin');
        $admin->setEmail('drivn.cook.equipe@gmail.com');
        $admin->setBirthDate(new \DateTime());
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'azerty'
        ));
        $admin->setIsActivated(true);
        $manager->persist($admin);

        $romain = new Users();
        $romain->setIdRole($role_admin);
        $romain->setFirstName('Romain');
        $romain->setLastName('Pierucci');
        $romain->setPseudo('Norudah');
        $romain->setEmail('pierucci.romain@gmail.com');
        $romain->setBirthDate(new \DateTime());
        $romain->setPassword($this->passwordEncoder->encodePassword(
            $romain,
            'azerty'
        ));
        $romain->setIsActivated(true);
        $manager->persist($romain);




        // Création franchisés

        for($i = 0 ; $i < 10 ; $i++){
            $franchise = new Franchises();
            $franchise->setFirstName('Franchise'. $i);
            $franchise->setLastName('Default');
            $franchise->setEmail('franchise'. $i .'@drivncook.fr');
            $franchise->setIdAdresse($address);
            $franchise->setPassword($this->passwordEncoder->encodePassword(
                $franchise,
                'azerty'
            ));
            $franchise->setBirthDate(new \DateTime());
            $manager->persist($franchise);
        }




        // Création des capacité max

        // camion
        $truck_capacity = new MaxCapacities();
        $truck_capacity
            ->setMaxIngredients(1000)
            ->setMaxDrinks(500)
            ->setMaxDesserts(500)
            ->setMaxMeals(500);
        $manager->persist($truck_capacity);

        // entrepôts
        $warehouse_capacity = new MaxCapacities();
        $warehouse_capacity
            ->setMaxIngredients(10000)
            ->setMaxMeals(5000)
            ->setMaxDrinks(5000)
            ->setMaxDesserts(5000);
        $manager->persist($warehouse_capacity);





        // Création des entrepôts

        $warhouse = new Warehouses();
        $name = "Alpha";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setIdAdresse($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        $warhouse = new Warehouses();
        $name = "Beta";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setIdAdresse($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        $warhouse = new Warehouses();
        $name = "Omega";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setIdAdresse($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        $warhouse = new Warehouses();
        $name = "Zeta";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setIdAdresse($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);




        // Création des camions

        // Appartient à personne
        $empty_truck = new Trucks();
        $empty_truck
            ->setBrand("Citroen")
            ->setFactoryDate(new \DateTime())
            ->setModel("XH-456-FR")
            ->setStatus("Available")
            ->setIdMaxCapacity($truck_capacity);
        $manager->persist($empty_truck);

        // occupé par le dernier franchisé crée (le n°10)
        $occupied_truck = new Trucks();
        $occupied_truck
            ->setBrand("Peugeot")
            ->setFactoryDate(new \DateTime())
            ->setModel("TG-5648-FR")
            ->setStatus("Occupied")
            ->setIdMaxCapacity($truck_capacity)
            ->setIdFranchise($franchise);
        $manager->persist($occupied_truck);


        // En réparation ou autre -> Indisponible
        $indisponible_truck = new Trucks();
        $indisponible_truck
            ->setBrand("Lambo")
            ->setFactoryDate(new \DateTime())
            ->setModel("ET-9263-FR")
            ->setStatus("Indisponible")
            ->setIdMaxCapacity($truck_capacity);
        $manager->persist($indisponible_truck);



        // Créations des catégories et sous-catégories

        $ingredient = new Categories();


        $manager->flush();
    }
}
