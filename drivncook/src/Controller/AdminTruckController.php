<?php

namespace App\Controller;

use App\Entity\Truck;
use App\Form\TruckType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminTruckController extends AbstractController
{

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




}
