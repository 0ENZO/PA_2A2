<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Form\FranchisesType;
use App\Repository\FranchisesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/franchise") 
 */
class FranchisesController extends AbstractController
{

    /**
     * @Route("/profil", name="franchise_profil")
     */
    public function profil(Request $request){

        $franchise = $this->getUser();
        $form = $this->createForm(FranchisesType::class, $franchise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('franchise_profil');
        }

        return $this->render('franchises/profil.html.twig', [
            'franchise' => $franchise,
            'form' => $form->createView()
        ]);

    }

}