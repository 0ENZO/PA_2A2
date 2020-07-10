<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Role;
use App\Form\FranchiseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminFranchiseController extends AbstractController
{

    /**
     * @Route("/franchise", name="admin_franchise_show")
     */
    public function franchise_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $franchises = $em->getRepository(Franchise::class)->findAll();

        $franchise = new Franchise();
        $franchise->setIsActivated(0);
        $franchise->setRole($em->getRepository(Role::class)->findOneBy(["name" => "ROLE_FRANCHISE"]));
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->remove("isActivated");
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



}
