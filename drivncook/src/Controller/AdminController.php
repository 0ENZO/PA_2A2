<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Franchise;
use App\Entity\Product;
use App\Entity\SubCategory;
use App\Entity\Truck;
use App\Entity\User;
use App\Entity\Role;
use App\Entity\Event;
use App\Entity\Warehouse;

use App\Form\CategoryType;
use App\Form\FranchiseType;
use App\Form\ProductType;
use App\Form\TruckType;
use App\Form\SubCategoryType;
use App\Form\UserType;
use App\Form\EventType;

use App\Repository\FranchiseRepository;
use App\Repository\TruckRepository;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{

    // MENU ADMINISTRATEUR
    /**
     * @Route("/show", name="admin_show")
     */
    public function show(Request $request)
    {
        return $this->render('admin/show.html.twig');
    }




    // GESTION FRANCHISÉ

    /**
     * @Route("/franchise", name="admin_franchise_show")
     */
    public function franchise_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $franchises = $em->getRepository(Franchise::class)->findAll();

        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($franchise);
            $em->flush();

            $this->addFlash("success", "Un nouveau franchisé a été ajouté");
            return $this->redirectToRoute('admin_franchise_show');
        }

        return $this->render('admin/franchise.html.twig', [
            'franchises' => $franchises,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/franchise/edit/{id}", name="admin_franchise_edit")
     */
    public function franchise_edit(Franchise $franchise, Request $request)
    {
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash("primary", "Un franchisé a été modifié.");
            return $this->redirectToRoute('admin_franchise_show');
        }
        return $this->render('admin/franchise_edit.html.twig', [
            'franchise' => $franchise,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/franchise/delete/{id}", name="admin_franchise_delete", methods={"GET","POST"})
     */
    public function franchise_delete(Franchise $franchise)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();

        $this->addFlash("danger", "Le franchisé que vous avez sélectionné a été supprimé.");
        return $this->redirectToRoute('admin_franchise_show');
    }





    // GESTION CAMIONS

    /**
     * @Route("/truck", name="admin_truck_show")
     */
    public function truck_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $trucks = $em->getRepository(Truck::class)->findAll();

        $truck = new Truck();
        $form = $this->createForm(TruckType::class, $truck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($truck);
            $em->flush();

            $this->addFlash("success", "Un nouveau camion a été ajouté");
            return $this->redirectToRoute('admin_truck_show');
        }

        return $this->render('admin/truck.html.twig', [
            'trucks' => $trucks,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/truck/edit/{id}", name="admin_truck_edit")
     */
    public function truck_edit(Truck $truck, Request $request)
    {
        $form = $this->createForm(TruckType::class, $truck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash("primary", "Un camion a été modifié.");
            return $this->redirectToRoute('admin_truck_show');
        }

        return $this->render('admin/truck_edit.html.twig', [
            'truck' => $truck,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/truck/delete/{id}", name="admin_truck_delete", methods={"GET","POST"})
     */
    public function truck_delete(Truck $truck)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($truck);
        $entityManager->flush();

        $this->addFlash("danger", "Le camion que vous avez sélectionné a été supprimé.");
        return $this->redirectToRoute('admin_truck_show');
    }




    // GESTION UTILISATEURS

    /**
     * @Route("/user", name="admin_user_show")
     */
    public function user_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        $role = $em->getRepository(Role::class)->findOneByName('Client');
        $user = new User();
        $user->setRole($role);
        $form = $this->createForm(UserType::class, $user);
        $form->remove('idRole');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Un nouvel utilisateur a été ajouté");
            return $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/user.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="admin_user_edit")
     */
    public function user_edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->remove('idRole');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash("primary", "Un utilisateur a été modifié.");
            return $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/User_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="admin_user_delete", methods={"GET","POST"})
     */
    public function user_delete(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash("danger", "L'utilisateur que vous avez sélectionné a été supprimé.");
        return $this->redirectToRoute('admin_user_show');
    }





    //GESTION EVENTS

    /**
    * @Route("/event", name="admin_event_show")
    */
    public function event_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAll();

        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($event);
            $em->flush();

            $this->addFlash("success", "Un nouvel event a été ajouté");
            return $this->redirectToRoute('admin_event_show');
        }


        return $this->render('admin/event.html.twig', [
            'events' => $events,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/event/edit/{id}", name="admin_event_edit")
     */
    public function event_edit($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository(Event::class)->find($id);

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->flush();

            $this->addFlash("primary", "Un event a été modifié");
            return $this->redirectToRoute("admin_event_show");
        }

        return $this->render("admin/event_edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/event/delete/{id}", name="admin_event_delete", methods={"GET","POST"})
     */
    public function event_delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $event = $entityManager->getRepository(Event::class)->findOneBy(["id" => $id]);
        $entityManager->remove($event);
        $entityManager->flush();

        $this->addFlash("danger", "L'event que vous avez sélectionné a été supprimé.");
        return $this->redirectToRoute('admin_event_show');
    }


    // GESTION CATEGORIES

    /**
     * @Route("/category",name="admin_category_show")
     */
    public function category_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $category = new Category();
        $repo = $manager->getRepository(Category::class);

        $categories = $repo->findAll();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->persist($category);
            $manager->flush();

            $this->addFlash("success", "Une nouvelle catégorie a été ajoutée");
            return $this->redirectToRoute("admin_category_show");
        }

        return $this->render("admin/categories.html.twig", [
            "form" => $form->createView(),
            "categories" => $categories,
        ]);
    }

    /**
     * @Route("/category/edit/{id}", name="admin_category_edit")
     */
    public function category_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $category = $manager->getRepository(Category::class)->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();

            $this->addFlash("primary", "Une catégorie a été modifiée");
            return $this->redirectToRoute("admin_category_show");
        }

        return $this->render("admin/categories_edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="admin_category_delete", methods={"GET", "POST"})
     */
    public function category_delete($id)
    {

        // Configurer VichUploader sur : delete_on_remove : false, ou on aura l'erreur suivante
        // error : Expected argument of type "string", "null" given at property path "fileName".

        $manager = $this->getDoctrine()->getManager();
        $category = $manager->getRepository(Category::class)->findOneBy(["id" => $id]);
        $manager->remove($category);
        $manager->flush();

        $this->addFlash("danger", "La catégorie que vous avez sélectionné a été supprimée");
        return $this->redirectToRoute("admin_category_show");
    }





    // GESTION SOUS CATGEGORIES

    /**
     * @Route("/sub_category", name="admin_sub_categories_show")
     */
    public function sub_category_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $sub_categories = $manager->getRepository(SubCategory::class)->findAll();
        $sub_category = new SubCategory();

        $form = $this->createForm(SubCategoryType::class, $sub_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->persist($sub_category);
            $manager->flush();

            $this->addFlash("success", "Une nouvelle sous-catégorie a été ajoutée");
            return $this->redirectToRoute("admin_sub_categories_show");
        }

        return $this->render("admin/sub_categories.html.twig", [
            "sub_categories" => $sub_categories,
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/sub_category/edit/{id}", name="admin_sub_category_edit")
     */
    public function sub_category_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $sub_category = $manager->getRepository(SubCategory::class)->find($id);

        $form = $this->createForm(SubCategoryType::class, $sub_category);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->flush();

            $this->addFlash("primary", "Une sous-catégorie a été modifiée");
            return $this->redirectToRoute("admin_sub_categories_show");
        }

        return $this->render("admin/sub_categories_edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/sub_category/delete/{id}", name="admin_sub_category_delete")
     */
    public function sub_category_delete($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $sub_category = $manager->getRepository(SubCategory::class)->find($id);

        $manager->remove($sub_category);
        $manager->flush();

        $this->addFlash("danger", "La sous-catégorie que vous avez sélectionné a été supprimée");
        return $this->redirectToRoute("admin_sub_categories_show");
    }









    // GESTION PRODUITS

    /**
     * @Route("/product", name="admin_product_show")
     */
    public function admin_product_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $products = $manager->getRepository(Product::class)->findAll();
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $price = $form["price"]->getData();
            $vat = $price * 0.20;
            $product->setVat($vat);

            $manager->persist($product);
            $manager->flush();

            $this->addFlash("success", "Vous avez ajouté un nouveau produit parmis les produits disponibles");
            return $this->redirectToRoute("admin_product_show");
        }

        return $this->render("admin/products.html.twig", [
            "form" => $form->createView(),
            "products" => $products,
        ]);
    }


    /**
     * @Route("/product/edit/{id}", name="admin_product_edit")
     */
    public function admin_product_edit($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository(Product::class)->find($id);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $price = $form["price"]->getData();
            $vat = $price * 0.20;
            $product->setVat($vat);

            $manager->flush();

            $this->addFlash("primary", "Les informations concernant le produit que vous venez de sélectionner ont été modifiées.");
            return $this->redirectToRoute("admin_product_show");
        }

        return $this->render("admin/products_edit.html.twig", [
            "form" => $form->createView()
        ]);
    }


    /**
     * @Route("/product/delete/{id}", name="admin_product_delete")
     */
    public function admin_product_delete($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository(Product::class)->find($id);

        $manager->remove($product);
        $manager->flush();

        $this->addFlash("danger", "Le produit que vous venez de sélectionner a été supprimé");
        return $this->redirectToRoute("admin_product_show");
    }






    // GESTION ENTREPÔTS

    /**
     * @Route("/warehouse", name="admin_warehouse_menu")
     */
    public function admin_warehouse_menu()
    {

        // TODO Récupérer les données des entrepots pour faire un menu d'un entrepots

        return $this->render("admin/warehouses_menu.html.twig");
    }


    /**
     * @Route("/warehouse/{name}", name="admin_warehouse_show")
     */
    public function admin_warehouse_show($name, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $warehouse = $manager->getRepository(Warehouse::class)->findOneBy(["name" => $name]);

        // TODO : Informations de l'entrepots. Tout ce qu'il contient.

        return $this->render("admin/warehouse.html.twig");
    }
}
