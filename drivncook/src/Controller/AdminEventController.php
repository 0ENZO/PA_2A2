<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminEventController extends AbstractController
{

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


}
