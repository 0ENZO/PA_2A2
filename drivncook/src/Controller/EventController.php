<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
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
    public function show()
    {
        return $this->render('event/event.html.twig');
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
