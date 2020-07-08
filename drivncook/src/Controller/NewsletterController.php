<?php

namespace App\Controller;

use Swift_Mailer;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Message;
use App\Entity\Franchise;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/message") 
 */
class NewsletterController extends AbstractController
{

    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/newsletter", name="newsletter")
     * IsGranted("ROLE_EDITOR")
     */
    public function index(MessageRepository $messageRepository, Request $request, Session $session, EntityManagerInterface $em)
    {

        $messages = $messageRepository->findAll();
        $plannedMessages = $messageRepository->findPlannedMessages();
        $expiredMessages = $messageRepository->findExpiredMessages();
        $sentMessages = $messageRepository->findByIsSent('1');

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form
            ->remove('editor')
            ->remove('createdAt');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $message->setEditor($this->getUser());
            $message->setCreatedAt(new \Datetime());
            $em->persist($message);
            $em->flush();

            if($form->get('isSent')->getData() != null){
                $this->sent($message->getId());
                $this->addFlash("success", "Votre message a été envoyé");
            } else {
                $this->addFlash("info", "Votre mail a été pris en compte.");
            }
            return $this->redirectToRoute('newsletter');
        }

        return $this->render('newsletter/index.html.twig', [
            'messages' => $messages,
            'plannedMessages' => $plannedMessages,
            'expiredMessages' => $expiredMessages, 
            'sentMessages' => $sentMessages,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/modifier/{id}", name="message_edit", requirements={"id"="\d+"})
     * IsGranted("ROLE_EDITOR")
     */
    public function edit(Request $request, Message $message, EntityManagerInterface $em)
    {
        $form = $this->createForm(MessageType::class, $message);
        $form
            ->remove('editor')
            ->remove('createdAt')
            ->remove('isSent')
            ;

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Message modifié');
            return $this->redirectToRoute('newsletter');
        }

        return $this->render('newsletter/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/supprimer/{id}", name="message_delete", methods={"DELETE", "GET"}, requirements={"id"="\d+"})
     * IsGranted("ROLE_EDITOR")
     */
    public function delete(Request $request, Message $message, EntityManagerInterface $em): Response
    {

        if ($this->isGranted('ROLE_EDITOR')){
            $em->remove($message);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', 'Message supprimé');
        } else{
            throw new NotFoundHttpException("Vous n'êtes pas autorisé à affectuer cette action.");
        }

        return $this->redirectToRoute('newsletter');
    }

    private function sent($id)
    {

        $em = $this->getDoctrine()->getManager();
        $messageRepository = $em->getRepository(Message::class);

        $message = $messageRepository->findOneById($id); 

        if ($message->getTarget() == 'user') {
            $role = $em->getRepository(Role::class)->findOneByName('ROLE_USER');
            $targets = $em->getRepository(User::class)->findByRole($role);
        } elseif ($message->getTarget() == 'franchise') {
            $role = $em->getRepository(Role::class)->findOneByName('FRANCHISE');
            $targets = $em->getRepository(Franchise::class)->findByRole($role);
        } 

        foreach ($targets as $target){
            $email = (new \Swift_Message())
                ->setSubject($message->getTitle())
                ->setFrom('drivn.cook.equipe@gmail.com')
                ->setTo($target->getEmail())
                ->setBcc('drivn.cook.equipe@gmail.com')
                ->setBody($message->getContent())
            ;   
            $this->mailer->send($email);
        }
    }

    /**
     * @Route("/newsletter/envoyer", name="send_newsletter")
     */
    public function newsletter(MessageRepository $messageRepository):Response
    {
        $messages = $messageRepository->isPlannedForToday();
        // var_dump($messageRepository->isPlannedForTodayRequest() );
        var_dump($messages);
        if ($messages){
            foreach ($messages as $message){
                $this->sent($message->getId());
            }
            return new Response('Sent.');
        } else 
            return new Response('No message planned.');
    }

}
