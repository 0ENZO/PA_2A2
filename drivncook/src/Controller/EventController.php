<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Entity\Franchise;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/event")
*/
class EventController extends AbstractController
{

    /**
     * @Route("/", name="show_event")
     */
    public function show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAll();

        return $this->render('event/show.html.twig', [ 
            'events' => $events
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $formView = $form->createView();
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em ->persist($event);
            $em->flush($event);

            return $this->redirectToRoute('eventshow');
        }

        return $this->render('event/eventCreate.html.twig', [
            'form' =>$formView
         ]);
    }
}
