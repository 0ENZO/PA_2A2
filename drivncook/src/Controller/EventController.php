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
* @Route("/event", name="event")
*/
class EventController extends AbstractController
{
    /**
     * @Route("/show", name="show")
     */
    public function show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $franchise = $this->getUser()->getId();
        dump($franchise);
        $events = $em->getRepository(Event::class)->findOneBy(["franchise" => $franchise]);


        return $this->render('event/event.html.twig', [ 'events' => $events]);
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
