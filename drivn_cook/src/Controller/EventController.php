<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\EventType;

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
     * @Route("/", name="event_show")
     */
    public function show()
    {
        return $this->render('event/event.html.twig');
    }

    /**
     * @Route("/create", name="event_create")
     */
    public function create(Request $request)
    {
        $event = new Events();
        $form = $this->createForm(EventType::class, $event);

        return $this->render('event/eventCreate.html.twig', [
             'form' => $form->createView()
         ]);
    }
}
