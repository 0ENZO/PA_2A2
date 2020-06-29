<?php

namespace App\Controller;

use App\Entity\AnswerReportBreakdown;
use App\Form\AnswerReportBreakdownType;
use App\Repository\AnswerReportBreakdownRepository;
use App\Repository\ReportBreakdownRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;


/**
 * @Route("/panne") 
 */
class BreakdownController extends AbstractController
{

    /**
     * @Route("/{id}", name="show_breakdown", requirements={"id"="\d+"})
     */
    public function show($id, Request $request, ReportBreakdownRepository $reportBreakdownRepository, AnswerReportBreakdownRepository $answerReportBreakdownRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $reportBreakdown = $reportBreakdownRepository->findOneById($id);
        $answerReportBreakdowns = $answerReportBreakdownRepository->findByReportBreakdown($reportBreakdown);

        // || !$this->isGranted('ROLE_ADMIN') Vérif si user est un admin 
        /*
        if (!($this->getUser() == $reportBreakdown->getTruck()->getFranchise())){
            throw new AccessDeniedException("Vous n'avez pas accès à cette page");    
        }
        */

        $answer = new AnswerReportBreakdown();
        $form = $this->createForm(AnswerReportBreakdownType::class, $answer);
        $form
            ->remove('reportBreakdown')
            ->remove('user')
            ->remove('date')
            ;

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $answer->setReportBreakdown($reportBreakdown);
            $answer->setUser($this->getUser());
            $answer->setDate(new \DateTime());
            $em->persist($answer);
            $em->flush();

            $this->addFlash("primary", "La réponse a été envoyée");
            return $this->redirectToRoute("show_breakdown", [
                'id' =>$id
            ]);
        }

        return $this->render('truck/breakdown.html.twig', [
            'reportBreakdown' => $reportBreakdown,
            'answerReportBreakdowns' => $answerReportBreakdowns,
            'form' => $form->createView()
        ]);
    }
}