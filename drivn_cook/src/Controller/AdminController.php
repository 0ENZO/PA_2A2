<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Form\FranchisesType;
use App\Repository\FranchisesRepository;
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
    public function franchise_show()
    {
        $em = $this->getDoctrine()->getManager();

        $franchises = $em->getRepository(Franchises::class)->findAll();
        
        return $this->render('admin/franchises.html.twig', [
            'franchises' => $franchises
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
    
}