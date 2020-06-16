<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\Trucks;
use App\Entity\Users;
use App\Entity\Roles;
use App\Entity\Events;

use App\Form\FranchisesType;
use App\Form\TrucksType;
use App\Form\UsersType;
use App\Form\EventType;

use App\Repository\FranchisesRepository;
use App\Repository\TrucksRepository;
use App\Repository\UsersRepository;
use App\Repository\RolesRepository;
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

    /**
     * @Route("/show", name="admin_show")
     */
    public function show(Request $request)
    {
        return $this->render('admin/show.html.twig');
    }

    /**
     * @Route("/franchise", name="admin_franchise_show")
     */
    public function franchise_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $franchises = $em->getRepository(Franchises::class)->findAll();

        $franchise = new Franchises();
        $form = $this->createForm(FranchisesType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($franchise);
            $em->flush();

            return $this->redirectToRoute('admin_franchise_show');
        }

        return $this->render('admin/franchises.html.twig', [
            'franchises' => $franchises,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/franchise/edit/{id}", name="admin_franchise_edit")
     */
    public function franchise_edit(Franchises $franchise, Request $request)
    {
        $form = $this->createForm(FranchisesType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_franchise_show');
        }

        return $this->render('admin/franchises_edit.html.twig', [
            'franchise' => $franchise,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/franchise/delete/{id}", name="admin_franchise_delete", methods={"GET","POST"})
     */
    public function franchise_delete(Franchises $franchise)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($franchise);
        $entityManager->flush();

        return $this->redirectToRoute('admin_franchise_show');
    }

    /**
     * @Route("/truck", name="admin_truck_show")
     */
    public function truck_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $trucks = $em->getRepository(Trucks::class)->findAll();

        $truck = new Trucks();
        $form = $this->createForm(TrucksType::class, $truck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($truck);
            $em->flush();

            return $this->redirectToRoute('admin_truck_show');
        }

        return $this->render('admin/trucks.html.twig', [
            'trucks' => $trucks,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/truck/edit/{id}", name="admin_truck_edit")
     */
    public function truck_edit(Trucks $truck, Request $request)
    {
        $form = $this->createForm(TrucksType::class, $truck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_truck_show');
        }

        return $this->render('admin/trucks_edit.html.twig', [
            'truck' => $truck,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/truck/delete/{id}", name="admin_truck_delete", methods={"GET","POST"})
     */
    public function truck_delete(Trucks $truck)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($truck);
        $entityManager->flush();

        return $this->redirectToRoute('admin_truck_show');
    }

    /**
         * @Route("/user", name="admin_user_show")
         */
    public function user_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(Users::class)->findAll();

        $role = $em->getRepository(Roles::class)->findOneByName('Client');
        $user = new Users();
        $user->setIdRole($role);
        $form = $this->createForm(UsersType::class, $user);
        $form->remove('idRole');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/users.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="admin_user_edit")
     */
    public function user_edit(Users $user, Request $request)
    {
        $form = $this->createForm(UsersType::class, $user);
        $form->remove('idRole');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/Users_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="admin_user_delete", methods={"GET","POST"})
     */
    public function user_delete(Users $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin_user_show');
    }

    /**
    * @Route("/event", name="admin_event_show")
    */
    public function event_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Events::class)->findAll();

        $event = $em->getRepository(Events::class)->findOneByidEvent('16');
        dump($event);
        $list = $em->getRepository(Franchises::class)->findByidEvent('16');


        return $this->render('admin/event.html.twig', [
            'events' => $events,
        ]);
    }
}
