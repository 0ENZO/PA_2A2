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
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Entity\Warehouse;
use App\Entity\WarehouseStock;
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



        // RÔLES

        $role_client = new Role();
        $role_client->setName('Client');
        $manager->persist($role_client);

        $role_franchise = new Role();
        $role_franchise->setName('Franchise');
        $manager->persist($role_franchise);

        $role_admin = new Role();
        $role_admin->setName('Admin');
        $manager->persist($role_admin);






        // ADRESSES

        // Départements

        $department = new Department();
        $department->setName('Ile de France');
        $manager->persist($department);

        $department2 = new Department();
        $department2->setName('Loiret');
        $manager->persist($department2);

        $ille_et_vilaine = new Department();
        $ille_et_vilaine->setName('Ille et Vilaine');
        $manager->persist($ille_et_vilaine);

        $isere = new Department();
        $isere->setName('Isère');
        $manager->persist($isere);



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

        $orleans = new City();
        $orleans
            ->setName("Orléans")
            ->setDepartment($department2)
            ->setPostalCode("45000");
        $manager->persist($orleans);

        $rennes = new City();
        $rennes
            ->setName("Rennes")
            ->setDepartment($ille_et_vilaine)
            ->setPostalCode('35000');
        $manager->persist($rennes);

        $grenoble = new City();
        $grenoble
            ->setName('Grenoble')
            ->setDepartment($isere)
            ->setPostalCode('38000');
        $manager->persist($grenoble);



        // Addresse finale (ville + département + rue)

        $address = new Address();
        $address->setStreet('Avenue de la france libre');
        $address->setNumber('1');
        $address->setCity($city);
        $manager->persist($address);

        $address_warehouse_paris = new Address();
        $address_warehouse_paris
            ->setStreet("Rue de vendeaume")
            ->setNumber("42")
            ->setCity($city2);
        $manager->persist($address_warehouse_paris);

        $address_warehouse_orleans= new Address();
        $address_warehouse_orleans
            ->setStreet("Boulevards, droits des Hommes")
            ->setNumber("13")
            ->setCity($orleans);
        $manager->persist($address_warehouse_orleans);

        $address_warehouse_rennes = new Address();
        $address_warehouse_rennes
            ->setStreet('Boulevard de Verdun')
            ->setNumber('56')
            ->setCity($rennes);
        $manager->persist($address_warehouse_rennes);

        $address_warehouse_grenoble = new Address();
        $address_warehouse_grenoble
            ->setStreet("Rue Gustave Flaubert")
            ->setNumber('23')
            ->setCity($grenoble);
        $manager->persist($address_warehouse_grenoble);







        // UTILISATEURS

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








        // FRANCHISÉS

        for($i = 0 ; $i < 10 ; $i++){
            $franchise = new Franchise();
            $franchise->setRole($role_franchise);
            $franchise->setFirstName('Franchise'. $i);
            $franchise->setLastName('Default');
            $franchise->setEmail('franchise'. $i .'@drivncook.fr');
            $franchise->setAddress($address);
            $franchise->setPassword($this->passwordEncoder->encodePassword(
                $franchise,
                'azerty'
            ));
            // $franchise->setBirthDate(new \DateTime());
            $manager->persist($franchise);
        }








        // CAPACITÉS MAX

        // camion
        $truck_capacity = new MaxCapacity();
        $truck_capacity
            ->setMaxIngredients(1000)
            ->setMaxDrinks(250)
            ->setMaxDesserts(200)
            ->setMaxMeals(200)
            ->setName("Capacité camion standard");
        $manager->persist($truck_capacity);

        // entrepôts

        $main_warehouse_capacity = new MaxCapacity();
        $main_warehouse_capacity
            ->setMaxIngredients(50000)
            ->setMaxMeals(10000)
            ->setMaxDrinks(10000)
            ->setMaxDesserts(10000)
            ->setName("Capacité entrepôt Paris");
        $manager->persist($main_warehouse_capacity);

        $second_warehouse_capacity = new MaxCapacity();
        $second_warehouse_capacity
            ->setMaxIngredients(30000)
            ->setMaxMeals(5000)
            ->setMaxDrinks(5000)
            ->setMaxDesserts(5000)
            ->setName("Capacité entrepôt extérieur");
        $manager->persist($second_warehouse_capacity);








        // ENTREPOTS

        $warehouse_alpha = new Warehouse();
        $name = "Alpha";
        $warehouse_alpha
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse_paris)
            ->setPhoneNumber("0645733429")
            ->setMaxCapacity($main_warehouse_capacity);
        $manager->persist($warehouse_alpha);

        $warehouse_beta = new Warehouse();
        $name = "Beta";
        $warehouse_beta
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse_orleans)
            ->setPhoneNumber("0645733429")
            ->setMaxCapacity($second_warehouse_capacity);
        $manager->persist($warehouse_beta);

        $warehouse_omega = new Warehouse();
        $name = "Omega";
        $warehouse_omega
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse_rennes)
            ->setPhoneNumber("0645733429")
            ->setMaxCapacity($second_warehouse_capacity);
        $manager->persist($warehouse_omega);

        $warehouse_zeta = new Warehouse();
        $name = "Zeta";
        $warehouse_zeta
            ->setName($name)
            ->setEmail($name."@drivncook.fr")
            ->setAddress($address_warehouse_grenoble)
            ->setPhoneNumber("0645733429")
            ->setMaxCapacity($second_warehouse_capacity);
        $manager->persist($warehouse_zeta);









        // CAMIONS

        // Appartient à personne
        $empty_truck = new Truck();
        $empty_truck
            ->setBrand("Citroen")
            ->setFactoryDate(new \DateTime())
            ->setModel("XH-456-FR")
            ->setStatus("Disponible")
            ->setMaxCapacity($truck_capacity);
        $manager->persist($empty_truck);

        // occupé par le dernier franchisé crée (le n°10)
        $occupied_truck = new Truck();
        $occupied_truck
            ->setBrand("Peugeot")
            ->setFactoryDate(new \DateTime())
            ->setModel("TG-5648-FR")
            ->setStatus("Occupé")
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








        // CATEGORIES

        $category_ingredient = new Category();
        $category_ingredient
            ->setName('Ingrédients')
            ->setDescription("Tout ce qui est relatif aux ".$category_ingredient->getName().".");
        $manager->persist($category_ingredient);

        $category_boisson = new Category();
        $category_boisson
            ->setName('Boissons')
            ->setDescription("Tout ce qui est relatif aux ".$category_boisson->getName().".");
        $manager->persist($category_boisson);

        $category_dessert = new Category();
        $category_dessert
            ->setName('Desserts')
            ->setDescription("Tout ce qui est relatif aux ".$category_dessert->getName().".");
        $manager->persist($category_dessert);

        $category_repas = new Category();
        $category_repas
            ->setName('Repas')
            ->setDescription("Tout ce qui est relatif aux ".$category_repas->getName().".");
        $manager->persist($category_repas);











        // SOUS CATEGORIES

        //... des ingrédients

        $sub_category_standard = new SubCategory();
        $sub_category_standard
            ->setName("Standard (matières premières)")
            ->setDescription("Relatif aux produits Standard (matières premières)")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_standard);

        $sub_category_legume = new SubCategory();
        $sub_category_legume
            ->setName("Légumes")
            ->setDescription("Relatif aux légumes")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_legume);

        $sub_category_fruit = new SubCategory();
        $sub_category_fruit
            ->setName("Fruits")
            ->setDescription("Relatif aux fruits")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_fruit);

        $sub_category_viande = new SubCategory();
        $sub_category_viande
            ->setName("Viandes")
            ->setDescription("Relatif aux viandes")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_viande);

        $sub_category_poisson = new SubCategory();
        $sub_category_poisson
            ->setName("Poissons")
            ->setDescription("Relatif aux poissons")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_poisson);

        $sub_category_cereale = new SubCategory();
        $sub_category_cereale
            ->setName("Céréales")
            ->setDescription("Relatif aux céréales")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_cereale);

        $sub_category_oleagineu = new SubCategory();
        $sub_category_oleagineu
            ->setName("Oléagineux")
            ->setDescription("Relatif aux oléagineux")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_oleagineu);

        $sub_category_graine = new SubCategory();
        $sub_category_graine
            ->setName("Graines")
            ->setDescription("Relatif aux graines")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_graine);

        $sub_category_product_annexe = new SubCategory();
        $sub_category_product_annexe
            ->setName("Produits annexes")
            ->setDescription("Relatif aux produits annexes")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_product_annexe);

        $sub_category_glace = new SubCategory();
        $sub_category_glace
            ->setName("Glaces")
            ->setDescription("Relatif aux glaces")
            ->setCategory($category_ingredient);
        $manager->persist($sub_category_glace);

        //... des boissons

        $sub_category_canette = new SubCategory();
        $sub_category_canette
            ->setName("Canettes")
            ->setDescription("Relatif aux boissons en canettes")
            ->setCategory($category_boisson);
        $manager->persist($sub_category_canette);

        $sub_category_bouteille_verre = new SubCategory();
        $sub_category_bouteille_verre
            ->setName("Bouteilles en verres")
            ->setDescription("Relatif aux boissons en bouteilles en verres")
            ->setCategory($category_boisson);
        $manager->persist($sub_category_bouteille_verre);

        $sub_category_boisson_chaude = new SubCategory();
        $sub_category_boisson_chaude
            ->setName("Boissons chaudes")
            ->setDescription("Relatif aux boissons chaudes")
            ->setCategory($category_boisson);
        $manager->persist($sub_category_boisson_chaude);

        $sub_category_jus = new SubCategory();
        $sub_category_jus
            ->setName("Jus")
            ->setDescription("Relatif aux jus")
            ->setCategory($category_boisson);
        $manager->persist($sub_category_jus);

        $sub_category_smoothie = new SubCategory();
        $sub_category_smoothie
            ->setName("Smoothies")
            ->setDescription("Relatif aux smoothies")
            ->setCategory($category_boisson);
        $manager->persist($sub_category_smoothie);

        //... des desserts

        $sub_category_dessert_industriel = new SubCategory();
        $sub_category_dessert_industriel
            ->setName("Desserts pré-fait")
            ->setDescription("Relatif aux désserts préfabriqués")
            ->setCategory($category_dessert);
        $manager->persist($sub_category_dessert_industriel);

        $sub_category_crepe = new SubCategory();
        $sub_category_crepe
            ->setName("Crêpes")
            ->setDescription("Relatif aux crêpes")
            ->setCategory($category_dessert);
        $manager->persist($sub_category_crepe);

        $sub_dessert_normal = new SubCategory();
        $sub_dessert_normal
            ->setName("Dessert classique")
            ->setDescription("Relatif aux dessert classiques")
            ->setCategory($category_dessert);
        $manager->persist($sub_dessert_normal);

        //... des plats

        $sub_category_plat_industriel = new SubCategory();
        $sub_category_plat_industriel
            ->setName("Plats pré-fait")
            ->setDescription("Relatif aux plats pré-fabriqués")
            ->setCategory($category_repas);
        $manager->persist($sub_category_plat_industriel);

        $sub_category_galette = new SubCategory();
        $sub_category_galette
            ->setName("Galettes")
            ->setDescription("Relatif aux galettes")
            ->setCategory($category_repas);
        $manager->persist($sub_category_galette);

        $sub_category_brunch = new SubCategory();
        $sub_category_brunch
            ->setName("Brunchs")
            ->setDescription("Relatif aux brunchs")
            ->setCategory($category_repas);
        $manager->persist($sub_category_brunch);














        // PRODUITS

        //... produits standars parmis les ingrédients

        $product_oeuf = new Product();
        $product_oeuf
            ->setName("Oeufs")
            ->setDescription("Description ".$product_oeuf->getName())
            ->setPrice(1.00)
            ->setVat($product_oeuf->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Unit");
        $manager->persist($product_oeuf);

        $product_pain = new Product();
        $product_pain
            ->setName("Pains")
            ->setDescription("Une baguette de pain ".$product_pain->getName())
            ->setPrice(0.70)
            ->setVat($product_pain->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Unit");
        $manager->persist($product_pain);

        $product_mouillette = new Product();
        $product_mouillette
            ->setName("Mouillettes")
            ->setDescription("Description ".$product_mouillette->getName())
            ->setPrice(5.00)
            ->setVat($product_mouillette->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_mouillette);

        $product_tranche_pain = new Product();
        $product_tranche_pain
            ->setName("Tranches de pains")
            ->setDescription("Description ".$product_tranche_pain->getName())
            ->setPrice(6.00)
            ->setVat($product_tranche_pain->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_tranche_pain);

        $product_farine = new Product();
        $product_farine
            ->setName("Farine")
            ->setDescription("Description ".$product_farine->getName())
            ->setPrice(2.00)
            ->setVat($product_farine->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_farine);

        $product_sel = new Product();
        $product_sel
            ->setName("Sel")
            ->setDescription("Description ".$product_sel->getName())
            ->setPrice(2.00)
            ->setVat($product_sel->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_sel);

        $product_gros_sel = new Product();
        $product_gros_sel
            ->setName("Gros sel")
            ->setDescription("Description ".$product_gros_sel->getName())
            ->setPrice(2.50)
            ->setVat($product_gros_sel->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_gros_sel);

        $product_lait = new Product();
        $product_lait
            ->setName("Lait")
            ->setDescription("Description ".$product_lait->getName())
            ->setPrice(1.70)
            ->setVat($product_lait->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("L");
        $manager->persist($product_lait);

        $product_beurre = new Product();
        $product_beurre
            ->setName("Beurre")
            ->setDescription("Description ".$product_beurre->getName())
            ->setPrice(3)
            ->setVat($product_beurre->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_beurre);

        $product_sucre = new Product();
        $product_sucre
            ->setName("Sucre")
            ->setDescription("Description ".$product_sucre->getName())
            ->setPrice(1.50)
            ->setVat($product_sucre->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_sucre);

        $product_fromage_rais = new Product();
        $product_fromage_rais
            ->setName("Fromage frais")
            ->setDescription("Description ".$product_fromage_rais->getName())
            ->setPrice(4.80)
            ->setVat($product_fromage_rais->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_fromage_rais);

        $product_gruyere = new Product();
        $product_gruyere
            ->setName("Gruyère")
            ->setDescription("Description ".$product_gruyere->getName())
            ->setPrice(3.20)
            ->setVat($product_gruyere->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_gruyere);

        $product_pourdre_coco = new Product();
        $product_pourdre_coco
            ->setName("Poudre Coco")
            ->setDescription("Description ".$product_pourdre_coco->getName())
            ->setPrice(4.80)
            ->setVat($product_pourdre_coco->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_pourdre_coco);

        $product_canelle = new Product();
        $product_canelle
            ->setName("Canelle")
            ->setDescription("Description ".$product_canelle->getName())
            ->setPrice(6.30)
            ->setVat($product_canelle->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_standard)
            ->setType("Kg");
        $manager->persist($product_canelle);

        //... produits légumes parmis les ingrédients

        $product_haricot_vert = new Product();
        $product_haricot_vert
            ->setName("Haricots verts")
            ->setDescription("Description ".$product_haricot_vert->getName())
            ->setPrice(4.10)
            ->setVat($product_haricot_vert->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_legume)
            ->setType("Kg");
        $manager->persist($product_haricot_vert);

        $product_haricot_beurre = new Product();
        $product_haricot_beurre
            ->setName("Haricots beurre")
            ->setDescription("Description ".$product_haricot_beurre->getName())
            ->setPrice(4.60)
            ->setVat($product_haricot_beurre->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_legume)
            ->setType("Kg");
        $manager->persist($product_haricot_beurre);

        $product_salade = new Product();
        $product_salade
            ->setName("Salades")
            ->setDescription("Description ".$product_salade->getName())
            ->setPrice(2.30)
            ->setVat($product_salade->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_legume)
            ->setType("Kg");
        $manager->persist($product_salade);

        $product_patate = new Product();
        $product_patate
            ->setName("Pommes de terres")
            ->setDescription("Description ".$product_patate->getName())
            ->setPrice(2.80)
            ->setVat($product_patate->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_legume)
            ->setType("Kg");
        $manager->persist($product_patate);

        $product_pousse_epinard = new Product();
        $product_pousse_epinard
            ->setName("Pousse d'épinards")
            ->setDescription("Description ".$product_pousse_epinard->getName())
            ->setPrice(4.98)
            ->setVat($product_pousse_epinard->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_legume)
            ->setType("Kg");
        $manager->persist($product_pousse_epinard);

        // fruits parmis les ingrédients

        $product_tomate = new Product();
        $product_tomate
            ->setName("Tomates")
            ->setDescription("Description ".$product_tomate->getName())
            ->setPrice(1.10)
            ->setVat($product_tomate->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Unit");
        $manager->persist($product_tomate);

        $product_banane = new Product();
        $product_banane
            ->setName("Bananes")
            ->setDescription("Description ".$product_banane->getName())
            ->setPrice(1.00)
            ->setVat($product_banane->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Unit");
        $manager->persist($product_banane);

        $product_kiwi = new Product();
        $product_kiwi
            ->setName("Kiwi")
            ->setDescription("Description ".$product_kiwi->getName())
            ->setPrice(1.00)
            ->setVat($product_kiwi->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Unit");
        $manager->persist($product_kiwi);

        $product_pomme = new Product();
        $product_pomme
            ->setName("Pomme")
            ->setDescription("Description ".$product_pomme->getName())
            ->setPrice(1.00)
            ->setVat($product_pomme->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Unit");
        $manager->persist($product_pomme);

        $product_orange = new Product();
        $product_orange
            ->setName("Orange")
            ->setDescription("Description ".$product_orange->getName())
            ->setPrice(1.00)
            ->setVat($product_orange->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Unit");
        $manager->persist($product_orange);

        $product_framboise = new Product();
        $product_framboise
            ->setName("Framboises")
            ->setDescription("Description ".$product_framboise->getName())
            ->setPrice(6.00)
            ->setVat($product_framboise->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Kg");
        $manager->persist($product_framboise);

        $product_myrtille = new Product();
        $product_myrtille
            ->setName("Myrtilles")
            ->setDescription("Description ".$product_myrtille->getName())
            ->setPrice(5.80)
            ->setVat($product_myrtille->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_fruit)
            ->setType("Kg");
        $manager->persist($product_myrtille);

        //... produits poissons parmis les ingrédients

        $product_sardine = new Product();
        $product_sardine
            ->setName("Sardines")
            ->setDescription("Description ".$product_sardine->getName())
            ->setPrice(28.20)
            ->setVat($product_sardine->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_poisson)
            ->setType("Kg");
        $manager->persist($product_sardine);

        $product_saumon = new Product();
        $product_saumon
            ->setName("Saumons")
            ->setDescription("Description ".$product_saumon->getName())
            ->setPrice(30.20)
            ->setVat($product_saumon->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_poisson)
            ->setType("Kg");
        $manager->persist($product_saumon);

        //... produits viandes parmis les ingrédients

        $product_bacon = new Product();
        $product_bacon
            ->setName("Bacon")
            ->setDescription("Description ".$product_bacon->getName())
            ->setPrice(18.20)
            ->setVat($product_bacon->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_viande)
            ->setType("Kg");
        $manager->persist($product_bacon);

        $product_saucisse = new Product();
        $product_saucisse
            ->setName("Saucisses")
            ->setDescription("Description ".$product_saucisse->getName())
            ->setPrice(16.80)
            ->setVat($product_saucisse->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_viande)
            ->setType("Kg");
        $manager->persist($product_saucisse);

        $product_jambon_blanc = new Product();
        $product_jambon_blanc
            ->setName("Jambon blanc")
            ->setDescription("Description ".$product_jambon_blanc->getName())
            ->setPrice(20.00)
            ->setVat($product_jambon_blanc->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_viande)
            ->setType("Kg");
        $manager->persist($product_jambon_blanc);

        $product_jambon_pays = new Product();
        $product_jambon_pays
            ->setName("Jambon de Pays")
            ->setDescription("Description ".$product_jambon_pays->getName())
            ->setPrice(25.00)
            ->setVat($product_jambon_pays->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_viande)
            ->setType("Kg");
        $manager->persist($product_jambon_pays);

        //... produits céréales parmis les ingrédients

        $product_flocon_avoine = new Product();
        $product_flocon_avoine
            ->setName("Flocons d'avoines")
            ->setDescription("Description ".$product_flocon_avoine->getName())
            ->setPrice(3.50)
            ->setVat($product_flocon_avoine->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_cereale)
            ->setType("Kg");
        $manager->persist($product_flocon_avoine);

        $product_flocon_soja = new Product();
        $product_flocon_soja
            ->setName("Flocons de soja")
            ->setDescription("Description ".$product_flocon_soja->getName())
            ->setPrice(3.80)
            ->setVat($product_flocon_soja->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_cereale)
            ->setType("Kg");
        $manager->persist($product_flocon_soja);

        $product_flocon_ble = new Product();
        $product_flocon_ble
            ->setName("Flocons de Blé")
            ->setDescription("Description ".$product_flocon_ble->getName())
            ->setPrice(3.20)
            ->setVat($product_flocon_ble->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_cereale)
            ->setType("Kg");
        $manager->persist($product_flocon_ble);

        $product_flocon_mais = new Product();
        $product_flocon_mais
            ->setName("Flocons de Maïs")
            ->setDescription("Description ".$product_flocon_mais->getName())
            ->setPrice(3.40)
            ->setVat($product_flocon_mais->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_cereale)
            ->setType("Kg");
        $manager->persist($product_flocon_mais);

        //... produits oléagineux parmis les ingrédients

        $product_amande = new Product();
        $product_amande
            ->setName("Amandes")
            ->setDescription("Description ".$product_amande->getName())
            ->setPrice(7.20)
            ->setVat($product_amande->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_oleagineu)
            ->setType("Kg");
        $manager->persist($product_amande);

        $product_noisette = new Product();
        $product_noisette
            ->setName("Noisettes")
            ->setDescription("Description ".$product_noisette->getName())
            ->setPrice(6.50)
            ->setVat($product_noisette->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_oleagineu)
            ->setType("Kg");
        $manager->persist($product_noisette);

        $product_noix= new Product();
        $product_noix
            ->setName("Noix")
            ->setDescription("Description ".$product_noix->getName())
            ->setPrice(6.20)
            ->setVat($product_noix->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_oleagineu)
            ->setType("Kg");
        $manager->persist($product_noix);

        $product_noix_bresil= new Product();
        $product_noix_bresil
            ->setName("Noix du Brésil")
            ->setDescription("Description ".$product_noix_bresil->getName())
            ->setPrice(8.40)
            ->setVat($product_noix_bresil->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_oleagineu)
            ->setType("Kg");
        $manager->persist($product_noix_bresil);

        $product_noix_pecan= new Product();
        $product_noix_pecan
            ->setName("Noix de Pecan")
            ->setDescription("Description ".$product_noix_pecan->getName())
            ->setPrice(8.20)
            ->setVat($product_noix_pecan->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_oleagineu)
            ->setType("Kg");
        $manager->persist($product_noix_pecan);

        //... produits graines parmis les ingrédients

        $product_graine_tournesol = new Product();
        $product_graine_tournesol
            ->setName("Graines de Trounesol")
            ->setDescription("Description ".$product_graine_tournesol->getName())
            ->setPrice(2.00)
            ->setVat($product_graine_tournesol->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_graine)
            ->setType("Kg");
        $manager->persist($product_graine_tournesol);

        $product_graine_courge = new Product();
        $product_graine_courge
            ->setName("Graines de Courges")
            ->setDescription("Description ".$product_graine_courge->getName())
            ->setPrice(2.50)
            ->setVat($product_graine_courge->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_graine)
            ->setType("Kg");
        $manager->persist($product_graine_courge);

        $product_graine_chia = new Product();
        $product_graine_chia
            ->setName("Graines de Chia")
            ->setDescription("Description ".$product_graine_chia->getName())
            ->setPrice(4.70)
            ->setVat($product_graine_chia->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_graine)
            ->setType("Kg");
        $manager->persist($product_graine_chia);

        $product_graine_pavot = new Product();
        $product_graine_pavot
            ->setName("Graines de Pavot")
            ->setDescription("Description ".$product_graine_pavot->getName())
            ->setPrice(3.60)
            ->setVat($product_graine_pavot->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_graine)
            ->setType("Kg");
        $manager->persist($product_graine_pavot);

        // produits annexes parmis les ingrédients

        $product_nutella = new Product();
        $product_nutella
            ->setName("Nutella")
            ->setDescription("Description ".$product_nutella->getName())
            ->setPrice(6.00)
            ->setVat($product_nutella->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_product_annexe)
            ->setType("Kg");
        $manager->persist($product_nutella);

        $product_chantilly = new Product();
        $product_chantilly
            ->setName("Chantilly")
            ->setDescription("Description ".$product_chantilly->getName())
            ->setPrice(1.00)
            ->setVat($product_chantilly->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_product_annexe)
            ->setType("Unit");
        $manager->persist($product_chantilly);

        // produits glace parmis les ingrédients

        $product_glace_vanille = new Product();
        $product_glace_vanille
            ->setName("Glace vanille")
            ->setDescription("Description ".$product_glace_vanille->getName())
            ->setPrice(4.00)
            ->setVat($product_glace_vanille->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_glace)
            ->setType("Kg");
        $manager->persist($product_glace_vanille);

        $product_glace_fraise = new Product();
        $product_glace_fraise
            ->setName("Glace fraise")
            ->setDescription("Description ".$product_glace_fraise->getName())
            ->setPrice(4.00)
            ->setVat($product_glace_fraise->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_glace)
            ->setType("Kg");
        $manager->persist($product_glace_fraise);

        $product_glace_coco = new Product();
        $product_glace_coco
            ->setName("Glace coco")
            ->setDescription("Description ".$product_glace_coco->getName())
            ->setPrice(4.00)
            ->setVat($product_glace_coco->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_glace)
            ->setType("Kg");
        $manager->persist($product_glace_coco);

        $product_glace_chocolat = new Product();
        $product_glace_chocolat
            ->setName("Glace chocolat")
            ->setDescription("Description ".$product_glace_chocolat->getName())
            ->setPrice(4.00)
            ->setVat($product_glace_chocolat->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_glace)
            ->setType("Kg");
        $manager->persist($product_glace_chocolat);

        //... produits canette parmis les boissons

        $product_canette_coca = new Product();
        $product_canette_coca
            ->setName("Canette de Coca")
            ->setDescription("Canette de 33cl de ".$product_canette_coca->getName())
            ->setPrice(1.10)
            ->setVat($product_canette_coca->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_canette)
            ->setType("Unit");
        $manager->persist($product_canette_coca);

        $product_canette_fanta = new Product();
        $product_canette_fanta
            ->setName("Canette de Fanta")
            ->setDescription("Canette de 33cl de ".$product_canette_fanta->getName())
            ->setPrice(1.10)
            ->setVat($product_canette_fanta->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_canette)
            ->setType("Unit");
        $manager->persist($product_canette_fanta);

        $product_canette_orangina = new Product();
        $product_canette_orangina
            ->setName("Canette d'Orangina")
            ->setDescription("Canette de 33cl de ".$product_canette_orangina->getName())
            ->setPrice(1.10)
            ->setVat($product_canette_orangina->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_canette)
            ->setType("Unit");
        $manager->persist($product_canette_orangina);

        //... produits bouteille en verre parmis les boissons

        $product_bouteille_coca = new Product();
        $product_bouteille_coca
            ->setName("Bouteille de coca")
            ->setDescription("Bouteille de 50cl de".$product_bouteille_coca->getName())
            ->setPrice(2.10)
            ->setVat($product_bouteille_coca->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_bouteille_verre)
            ->setType("Unit");
        $manager->persist($product_bouteille_coca);

        $product_bouteille_orangina = new Product();
        $product_bouteille_orangina
            ->setName("Bouteille d'orangina")
            ->setDescription("Bouteille de 50cl de".$product_bouteille_orangina->getName())
            ->setPrice(2.10)
            ->setVat($product_bouteille_orangina->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_bouteille_verre)
            ->setType("Unit");
        $manager->persist($product_bouteille_orangina);

        //... produits desserts industriels parmis les desserts

        $product_cookie = new Product();
        $product_cookie
            ->setName("Cookie")
            ->setDescription("Description ".$product_cookie->getName())
            ->setPrice(2.00)
            ->setVat($product_cookie->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_dessert_industriel)
            ->setType("Unit");
        $manager->persist($product_cookie);

        $product_brownie = new Product();
        $product_brownie
            ->setName("Brownie")
            ->setDescription("Description ".$product_brownie->getName())
            ->setPrice(3.20)
            ->setVat($product_brownie->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_dessert_industriel)
            ->setType("Unit");
        $manager->persist($product_brownie);

        $product_muffin = new Product();
        $product_muffin
            ->setName("Muffin")
            ->setDescription("Description ".$product_muffin->getName())
            ->setPrice(2.70)
            ->setVat($product_muffin->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_dessert_industriel)
            ->setType("Unit");
        $manager->persist($product_muffin);

        //Produits plats industriels parmis les plats

        $product_salade_complete = new Product();
        $product_salade_complete
            ->setName("Salade complète")
            ->setDescription("Description ".$product_salade_complete->getName())
            ->setPrice(4.50)
            ->setVat($product_salade_complete->getPrice() * 0.20)
            ->setStatus("Disponible")
            ->setQuantity(1)
            ->setSubCategory($sub_category_plat_industriel)
            ->setType("Unit");
        $manager->persist($product_salade_complete);







        // REMPLISSAGES DES ENTREPÔTS

        // remplissage alpha

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_oeuf)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_pain)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_mouillette)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_tranche_pain)
            ->setQuantity(150);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_farine)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_gros_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_sucre)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_lait)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_beurre)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_fromage_rais)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_gruyere)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_pourdre_coco)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_canelle)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_haricot_vert)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_haricot_beurre)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_salade)
            ->setQuantity(265);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_patate)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_pousse_epinard)
            ->setQuantity(50);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_tomate)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_banane)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_kiwi)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_pomme)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_orange)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_framboise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_myrtille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_sardine)
            ->setQuantity(110);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_saumon)
            ->setQuantity(230);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_bacon)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_saucisse)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_jambon_blanc)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_jambon_pays)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_flocon_avoine)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_flocon_soja)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_flocon_mais)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_flocon_ble)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_amande)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_noisette)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_noix)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_noix_bresil)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_noix_pecan)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_graine_chia)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_graine_pavot)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_graine_courge)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_graine_tournesol)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_nutella)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_chantilly)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_glace_chocolat)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_glace_fraise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_glace_vanille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_glace_coco)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_canette_fanta)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_canette_coca)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_canette_orangina)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_bouteille_coca)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_bouteille_orangina)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_cookie)
            ->setQuantity(2000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_brownie)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_muffin)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_alpha)
            ->setProduct($product_salade_complete)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);








        // Entrepot Beta

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_oeuf)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_pain)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_mouillette)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_tranche_pain)
            ->setQuantity(150);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_farine)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_gros_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_sucre)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_lait)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_beurre)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_fromage_rais)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_gruyere)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_pourdre_coco)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_canelle)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_haricot_vert)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_haricot_beurre)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_salade)
            ->setQuantity(265);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_patate)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_pousse_epinard)
            ->setQuantity(50);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_tomate)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_banane)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_kiwi)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_pomme)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_orange)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_framboise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_myrtille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_sardine)
            ->setQuantity(110);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_saumon)
            ->setQuantity(230);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_bacon)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_saucisse)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_jambon_blanc)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_jambon_pays)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_flocon_avoine)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_flocon_soja)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_flocon_mais)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_flocon_ble)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_amande)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_noisette)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_noix)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_noix_bresil)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_noix_pecan)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_graine_chia)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_graine_pavot)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_graine_courge)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_graine_tournesol)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_nutella)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_chantilly)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_glace_chocolat)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_glace_fraise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_glace_vanille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_glace_coco)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_canette_fanta)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_canette_coca)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_canette_orangina)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_bouteille_coca)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_bouteille_orangina)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_cookie)
            ->setQuantity(2000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_brownie)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_muffin)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_beta)
            ->setProduct($product_salade_complete)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);














        // Entrepot Omega

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_oeuf)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_pain)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_mouillette)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_tranche_pain)
            ->setQuantity(150);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_farine)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_gros_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_sucre)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_lait)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_beurre)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_fromage_rais)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_gruyere)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_pourdre_coco)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_canelle)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_haricot_vert)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_haricot_beurre)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_salade)
            ->setQuantity(265);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_patate)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_pousse_epinard)
            ->setQuantity(50);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_tomate)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_banane)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_kiwi)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_pomme)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_orange)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_framboise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_myrtille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_sardine)
            ->setQuantity(110);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_saumon)
            ->setQuantity(230);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_bacon)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_saucisse)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_jambon_blanc)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_jambon_pays)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_flocon_avoine)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_flocon_soja)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_flocon_mais)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_flocon_ble)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_amande)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_noisette)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_noix)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_noix_bresil)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_noix_pecan)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_graine_chia)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_graine_pavot)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_graine_courge)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_graine_tournesol)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_nutella)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_chantilly)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_glace_chocolat)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_glace_fraise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_glace_vanille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_glace_coco)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_canette_fanta)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_canette_coca)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_canette_orangina)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_bouteille_coca)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_bouteille_orangina)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_cookie)
            ->setQuantity(2000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_brownie)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_muffin)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_omega)
            ->setProduct($product_salade_complete)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);





        // Entrepot Zeta

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_oeuf)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_pain)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_mouillette)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_tranche_pain)
            ->setQuantity(150);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_farine)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_gros_sel)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_sucre)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_lait)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_beurre)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_fromage_rais)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_gruyere)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_pourdre_coco)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_canelle)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_haricot_vert)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_haricot_beurre)
            ->setQuantity(125);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_salade)
            ->setQuantity(265);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_patate)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_pousse_epinard)
            ->setQuantity(50);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_tomate)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_banane)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_kiwi)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_pomme)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_orange)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_framboise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_myrtille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_sardine)
            ->setQuantity(110);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_saumon)
            ->setQuantity(230);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_bacon)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_saucisse)
            ->setQuantity(250);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_jambon_blanc)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_jambon_pays)
            ->setQuantity(200);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_flocon_avoine)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_flocon_soja)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_flocon_mais)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_flocon_ble)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_amande)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_noisette)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_noix)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_noix_bresil)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_noix_pecan)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_graine_chia)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_graine_pavot)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_graine_courge)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_graine_tournesol)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_nutella)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_chantilly)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_glace_chocolat)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_glace_fraise)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_glace_vanille)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_glace_coco)
            ->setQuantity(300);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_canette_fanta)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_canette_coca)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_canette_orangina)
            ->setQuantity(1000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_bouteille_coca)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_bouteille_orangina)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_cookie)
            ->setQuantity(2000);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_brownie)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_muffin)
            ->setQuantity(500);
        $manager->persist($warehouse_stock);

        $warehouse_stock = new WarehouseStock();
        $warehouse_stock
            ->setWarehouse($warehouse_zeta)
            ->setProduct($product_salade_complete)
            ->setQuantity(100);
        $manager->persist($warehouse_stock);





        // Article
        
        $manager->flush();
    }
}
