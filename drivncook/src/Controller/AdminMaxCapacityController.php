<?php

namespace App\Controller;

use App\Entity\MaxCapacity;
use App\Entity\Truck;
use App\Entity\Warehouse;
use App\Form\MaxCapacityType;
use App\Service\MaxCapacityService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminMaxCapacityController extends AbstractController
{


    /**
     * @Route("/max-capacity", name="admin_max_capacity_show")
     */
    public function admin_max_capacity_show(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();

        $max_capacities = $manager->getRepository(MaxCapacity::class)->findAll();
        $max_capacity = new MaxCapacity();

        $form = $this->createForm(MaxCapacityType::class, $max_capacity);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $manager->persist($max_capacity);
            $manager->flush();

            $this->addFlash("success", "Une nouvelle capacité maximale a été ajoutée.");
            return $this->redirectToRoute("admin_max_capacity_show");
        }

        return $this->render("admin/maxCapacities/maxCapacities.html.twig", [
            "max_capacities" => $max_capacities,
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/max-capacity/edit/{id}", name="admin_max_capacity_edit")
     */
    public function admin_max_capacity_edit($id, Request $request, MaxCapacityService $maxCapacityService)
    {
        $manager = $this->getDoctrine()->getManager();
        $max_capacity = $manager->getRepository(MaxCapacity::class)->find($id);

        $form = $this->createForm(MaxCapacityType::class, $max_capacity);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {

            $manager->flush();

            $this->addFlash("primary", "Une capacité maximale a été modifiée.");
            return $this->redirectToRoute("admin_max_capacity_show");
        }

        return $this->render("admin/maxCapacities/maxCapacities_edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/max-capacity/delete/{id}", name="admin_max_capacity_delete")
     */
    public function admin_max_capacity_delete($id, Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $max_capacity = $manager->getRepository(MaxCapacity::class)->find($id);

        $manager->remove($max_capacity);
        $manager->flush();

        $this->addFlash("danger", "La capacité maximale que vous avez sélectionné a été supprimée");
        return $this->redirectToRoute("admin_max_capacity_show");
    }



}
