<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Entity\Franchise;
use App\Entity\User;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @isGranted("ROLE_FRANCHISE")
     */
    public function create(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $formView = $form->createView();
        $form->handleRequest($request);
        dump($event);

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

    /**
     * @Route("/rejoindre/{id}", name="event_join", requirements={"id"="\d+"})
     */
    public function addGuest($id, Request $request, EventRepository $eventRepository, EntityManagerInterface $em)
    {
        if ($this->isGranted('ROLE_USER')){
            $event = $eventRepository->findOneById($id);
            $event->addUser($this->getUser());
            $limit = $event->getTickets();
            $current = count($event->getUsers());

            $users = $event->getUsers();

            if($current == $limit){
                $this->addFlash("warning", "Toutes les places ont déjà été réservées.");
                return $this->redirectToRoute('event_index');
            }
            if ($users->contains($this->getUser())){
                $this->addFlash("warning", "Vous êtes déjà inscrit à cet évènement.");
                return $this->redirectToRoute('event_index');
            } 

            $em->flush();
            $this->addFlash("success", "Votre êtes inscris à l'évenement");
            return $this->redirectToRoute('event_index');
        }
    }

    /**
     * @Route("/quitter/{id}", name="event_remove", requirements={"id"="\d+"})
     */
    public function removeGuest($id, Request $request, EventRepository $eventRepository, EntityManagerInterface $em)
    {
        if ($this->isGranted('ROLE_USER')){
            $event = $eventRepository->findOneById($id);
            $users = $event->getUsers();

            if ($users->contains($this->getUser())){
                $event->removeUser($this->getUser());
                $em->flush();
                $this->addFlash("warning", "Vous n\'êtes plus inscris à cet évenement.");
                return $this->redirectToRoute('event_index');
            } 

            $em->flush();
            $this->addFlash("success", "Votre n\‘êtes pas inscris à l'évenement");
            return $this->redirectToRoute('event_index');
        }
    }
}
