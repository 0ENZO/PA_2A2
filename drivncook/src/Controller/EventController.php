<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Entity\Franchise;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("/evenement")
*/
class EventController extends AbstractController
{

    /**
     * @Route("/", name="event_index")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository(Event::class)->findAll();

        if ($this->isGranted('ROLE_FRANCHISE') || $this->isGranted('ROLE_EDITOR')) {
            $event = new Event();
            $form = $this->createForm(EventType::class, $event);
            if ($this->isGranted('ROLE_FRANCHISE'))
                $form->remove('franchise');
            $form->handleRequest($request);

            if ($form->isSubmitted() and $form->isValid()) {
                if ($this->isGranted('ROLE_FRANCHISE'))
                    $event->addFranchise($this->getUser());
                $em->persist($event);
                $em->flush();
                $this->addFlash("success", "Votre évenement a été publié");
                return $this->redirectToRoute("event_index");
            }

            return $this->render('event/index.html.twig', [ 
                'events' => $events,
                'form' => $form->createView(),
            ]);
        } 

        return $this->render('event/index.html.twig', [ 
            'events' => $events
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", requirements={"id"="\d+"})
     */
    public function show($id, EventRepository $eventRepository, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $eventRepository->findOneById($id);

        return $this->render('event/show.html.twig', [ 
            'event' => $event
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
