<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\MaxCapacity;
use App\Entity\Role;
use App\Entity\Truck;
use App\Entity\User;

use App\Entity\City;
use App\Entity\Address;
use App\Entity\Franchise;
use App\Entity\Department;
use App\Entity\Warehouse;
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

        $role_client = new Role();
        $role_client->setName('Client');
        $manager->persist($role_client);

        $role_franchise = new Role();
        $role_franchise->setName('Franchise');
        $manager->persist($role_franchise);

        $role_admin = new Role();
        $role_admin->setName('Admin');
        $manager->persist($role_admin);

        // Création adresse

        // Départements

        $department = new Department();
        $department->setName('Ile de France');
        $manager->persist($department);

        // Villes

        $city = new City();
        $city->setName('Creteil');
        $city->setPostalCode('94000');
        $city->setDepartment($department);
        $manager->persist($city);

        $city2 = new City();
        $city2
            ->setName("Paris")
            ->setDepartment($department)
            ->setPostalCode("75000");
        $manager->persist($city2);

        // Adresse finale (ville + département + rue)

        $address = new Address();
        $address->setStreet('Avenue de la france libre');
        $address->setNumber('1');
        $address->setCity($city);
        $manager->persist($address);

        $address_warehouse = new Address();
        $address_warehouse
            ->setStreet("Rue de vendeaume")
            ->setNumber("42")
            ->setCity($city2);
        $manager->persist($address_warehouse);

        // Création des premiers users : Client et Admin

        $client = new User();
        $client->setRole($role_client);
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

        $admin = new User();
        $admin->setRole($role_admin);
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

        $romain = new User();
        $romain->setRole($role_admin);
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
            $franchise = new Franchise();
            $franchise->setFirstName('Franchise'. $i);
            $franchise->setLastName('Default');
            $franchise->setEmail('franchise'. $i .'@drivncook.fr');
            $franchise->setAddress($address);
            $franchise->setPassword($this->passwordEncoder->encodePassword(
                $franchise,
                'azerty'
            ));
            $franchise->setRole($role_franchise);
            // $franchise->setBirthDate(new \DateTime());
            $manager->persist($franchise);
        }

        // Création des capacité max

        // camion
        $truck_capacity = new MaxCapacity();
        $truck_capacity
            ->setMaxIngredients(1000)
            ->setMaxDrinks(500)
            ->setMaxDesserts(500)
            ->setMaxMeals(500);
        $manager->persist($truck_capacity);

        // entrepôts
        $warehouse_capacity = new MaxCapacity();
        $warehouse_capacity
            ->setMaxIngredients(10000)
            ->setMaxMeals(5000)
            ->setMaxDrinks(5000)
            ->setMaxDesserts(5000);
        $manager->persist($warehouse_capacity);

        // Création des entrepôts

        $warhouse = new Warehouse();
        $name = "Alpha";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        $warhouse = new Warehouse();
        $name = "Beta";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        $warhouse = new Warehouse();
        $name = "Omega";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        $warhouse = new Warehouse();
        $name = "Zeta";
        $warhouse
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse)
            ->setPhoneNumber("0645733429");
        $manager->persist($warhouse);

        // Création des camions

        // Appartient à personne
        $empty_truck = new Truck();
        $empty_truck
            ->setBrand("Citroen")
            ->setFactoryDate(new \DateTime())
            ->setModel("XH-456-FR")
            ->setStatus("Available")
            ->setMaxCapacity($truck_capacity);
        $manager->persist($empty_truck);

        // occupé par le dernier franchisé crée (le n°10)
        $occupied_truck = new Truck();
        $occupied_truck
            ->setBrand("Peugeot")
            ->setFactoryDate(new \DateTime())
            ->setModel("TG-5648-FR")
            ->setStatus("Occupied")
            ->setMaxCapacity($truck_capacity)
            ->setFranchise($franchise);
        $manager->persist($occupied_truck);


        // En réparation ou autre -> Indisponible
        $indisponible_truck = new Truck();
        $indisponible_truck
            ->setBrand("Lambo")
            ->setFactoryDate(new \DateTime())
            ->setModel("ET-9263-FR")
            ->setStatus("Indisponible")
            ->setMaxCapacity($truck_capacity);
        $manager->persist($indisponible_truck);

        // Créations des catégories et sous-catégories

        $ingredient = new Category();

        $manager->flush();
    }
}
