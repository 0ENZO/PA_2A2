<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use App\Entity\Users;

use App\Entity\Cities;
use App\Entity\Addresses;
use App\Entity\Franchises;
use App\Entity\Departments;
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

        $department = new Departments();
        $department->setName('Ile de France');
        $manager->persist($department);

        $city = new Cities();
        $city->setName('Creteil');
        $city->setPostalNumber('94000');
        $city->setIdDepartment($department);
        $manager->persist($city);

        $address = new Addresses();
        $address->setStreet('Avenue de la france libre');
        $address->setNumber('1');
        $address->setIdCity($city);
        $manager->persist($address);

        // Création des premiers users : Client et Admin

        $client = new Users();
        $client->setIdRole($role_client);
        $client->setPseudo('Client_lambda');
        $client->setFirstName('Lee');
        $client->setLastName('Sin');
        $client->setEmail('client@drivn_cook.fr');
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

        // Création premier franchisé

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


        $manager->flush();
    }
}
