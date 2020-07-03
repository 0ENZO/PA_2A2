<?php

namespace App\Controller;

use App\Entity\Breakdown;
use App\Entity\BreakdownType;
use App\Entity\ReportBreakdown;

use App\Form\BreakdownsType;
use App\Form\BreakdownTypeType;
use App\Form\ReportBreakdownType;
use App\Repository\BreakdownRepository;
use App\Repository\BreakdownTypeRepository;
use App\Repository\ReportBreakdownRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminBreakdownController extends AbstractController
{

    /**
     * @Route("/pannes", name="admin_breakdown_show")
     */
    public function admin_breakdown_show(Request $request, BreakdownRepository $breakdownRepository, BreakdownTypeRepository $breakdownTypeRepository, ReportBreakdownRepository $reportBreakdownRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $breakdownTypes = $breakdownTypeRepository->findAll();
        $breakdowns = $breakdownRepository->findAll();

        $breakdown = new Breakdown();
        $breakdownType = new BreakdownType();

        $form_breakdown = $this->createForm(BreakdownsType::class, $breakdown);
        $form_breakdown->handleRequest($request);

        if ($form_breakdown->isSubmitted() and $form_breakdown->isValid()) {
            $em->persist($breakdown);
            $em->flush();

            $this->addFlash("primary", "Un type de panne a été ajouté");
            return $this->redirectToRoute("admin_breakdown_show");
        }

        $form_breakdownType = $this->createForm(BreakdownTypeType::class, $breakdownType);
        $form_breakdownType->handleRequest($request);

        if ($form_breakdownType->isSubmitted() and $form_breakdownType->isValid()) {
            $em->persist($breakdownType);
            $em->flush();

            $this->addFlash("primary", "Une panne a été ajouté");
            return $this->redirectToRoute("admin_breakdown_show");
        }


        return $this->render('admin/breakdown/show.html.twig', [
            'breakdownTypes' => $breakdownTypes,
            'breakdowns' => $breakdowns,
            'form_breakdown' => $form_breakdown->createView(),
            'form_breakdownType' => $form_breakdownType->createView()
        ]);
    }

    /**
     * @Route("/panne_type/{id}", name="admin_breakdownType_edit", requirements={"id"="\d+"})
     */
    public function admin_breakdownType_edit(Request $request, $id, BreakdownTypeRepository $breakdownTypeRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $breakdownType = $breakdownTypeRepository->findOneById($id);
        $form = $this->createForm(BreakdownTypeType::class, $breakdownType);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash("primary", "La panne type a été modifiée");
            return $this->redirectToRoute("admin_breakdown_show");
        }

        return $this->render('admin/breakdown/breakdownType/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/panne_type/supprimer/{id}", name="admin_breakdownType_delete", requirements={"id"="\d+"})
     */
    public function admin_breakdownType_delete($id, Request $request, BreakdownTypeRepository $breakdownTypeRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $breakdownType = $breakdownTypeRepository->findOneBy($id);

        $em->remove($breakdownType);
        $em->flush();

        $this->addFlash("danger", "La panne type a été supprimée");
        return $this->redirectToRoute("admin_breakdown_show");
    }

    /**
     * @Route("/panne/{id}", name="admin_breakdown_edit", requirements={"id"="\d+"})
     */
    public function admin_breakdown_edit(Request $request, $id, BreakdownRepository $breakdownRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $breakdown = $breakdownRepository->findOneById($id);
        $form = $this->createForm(BreakdownsType::class, $breakdown);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash("primary", "La panne type a été modifiée");
            return $this->redirectToRoute("admin_breakdown_show");
        }

        return $this->render('admin/breakdown/breakdownType/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/panne/supprimer/{id}", name="admin_breakdown_delete", requirements={"id"="\d+"})
     */
    public function admin_breakdown_delete($id, Request $request, BreakdownRepository $breakdownRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $breakdown = $breakdownRepository->findOneBy($id);

        $em->remove($breakdown);
        $em->flush();

        $this->addFlash("danger", "La panne a été supprimée");
        return $this->redirectToRoute("admin_breakdown_show");
    }

    /**
     * @Route("/SAV", name="admin_reportBreakdown_show")
     */
    public function admin_reportBreakdown_show(Request $request, ReportBreakdownRepository $reportBreakdownRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $reportBreakdowns = $reportBreakdownRepository->findAll();

        $report = new ReportBreakdown();

        $form = $this->createForm(ReportBreakdownType::class, $report);
        $form->remove('status');
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $report->setStatus('0');
            $em->persist($report);
            $em->flush();

            $this->addFlash("primary", "Une nouvelle panne a été enregistrée");
            return $this->redirectToRoute("admin_reportBreakdown_show");
        }

        return $this->render('admin/breakdown/report_show.html.twig', [
            'reportBreakdowns' => $reportBreakdowns,
            'form' => $form->createView()
        ]);
    }

}
