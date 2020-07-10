<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Truck;
use App\Entity\Breakdown;
use App\Entity\ReportBreakdown;
use App\Form\ReportBreakdownType;
use App\Repository\BreakdownRepository;
use App\Repository\TruckRepository;
use App\Repository\FranchiseRepository;
use App\Repository\ReportBreakdownRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * @Route("/camion")
 */
class TruckController extends AbstractController
{

    /**
     * @Route("/assigner/{idTruck}", name="assign_truck", requirements={"idTruck"="\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function assign($idTruck, TruckRepository $truckRepository, FranchiseRepository $franchiseRepository, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $truck = $truckRepository->findOneById($idTruck);

        if(!$truck->getFranchise()){

            $choices = $franchiseRepository->findAll();

            $form = $this->createFormBuilder()
            ->add('franchise', EntityType::class, array(
                'class' => Franchise::class,
                'choices' => $choices,
                'choice_label' => function ($value, $key, $index) {
                    return $value;
                    // return strtoupper($key);
                    // or if you want to translate some key
                    //return 'form.choice.'.$key;
                },
            ))
            ->getForm();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){

                $selected = $form->get('franchise')->getData();
                $truck->setFranchise($selected);
                $truck->setStatus('Occupé');
                $em->persist($truck);
                $em->flush();

                $this->addFlash('info', "Camion assigné.");
                return $this->redirectToRoute('admin_truck_show');
            }

            return $this->render('admin/truck/assign.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $this->addFlash('warning', "Ce camion est déjà assigné.");
        return $this->redirectToRoute('admin_truck_show');

    }


    /**
     * Affiche la fiche d'un camion
     * @Route("/{id}", name="show_truck", requirements={"id"="\d+"})
     * @param [type] $id
     */
    public function show($id, TruckRepository $truckRepository, ReportBreakdownRepository $reportBreakdownRepository)
    {
        $truck = $truckRepository->findOneById($id);
        // EA : Lié au franchisé et pas au camion
        $reportBreakdowns = $reportBreakdownRepository->findAll($truck);
        return $this->render('truck/show.html.twig',[
            'truck' => $truck,
            'reportBreakdowns' => $reportBreakdowns
        ]);
    }

    /**
     * @Route("/declarer/{id}", name="report_truck", requirements={"id"="\d+"})
     */
    public function report($id, TruckRepository $truckRepository, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $breakdown = new ReportBreakdown();
        $form = $this->createForm(ReportBreakdownType::class, $breakdown);

        $truck = $truckRepository->findOneById($id);
        $form->remove('truck');
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $breakdown->setTruck($truck);
            $em->persist($breakdown);
            $em->flush();
            $this->addFlash("success", "Votre panne a été déclarée");

            return $this->redirectToRoute('show_truck', [
                'id'=> $id
            ]);
        }

        return $this->render('truck/report.html.twig', [
            'form' => $form->createView(),
            'truck' => $truck
        ]);
    }
}
