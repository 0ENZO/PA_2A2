<?php

namespace App\Controller;


use App\Entity\Role;
use App\Entity\User;
use App\Entity\Vote;
use App\Form\UserType;
use App\Entity\UserOrder;
use App\Entity\CreditCard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/change-locale/{locale}", name="change_locale")
     */
    public function changeLocale($locale, Request $request)
    {
        // On stocke la langue demandée dans la session
        $request->getSession()->set('_locale', $locale);

        // On revient sur la page précédente
        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/profil", name="user_profil")
     */
    public function user_profil(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $orders = $em->getRepository(UserOrder::class)->findByUser($user);
        $credit_cards = $em->getRepository(CreditCard::class)->findBy(["user" => $user]);
        $votes = $em->getRepository(Vote::class)->findByUser($user);

        $form = $this->createForm(UserType::class, $user);
        $form
            ->remove("Role")
            ->remove('password');

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->flush();
            $this->addFlash("primary", "Vos modifications ont bien été pris en compte.");
            return $this->redirectToRoute('user_profil');
        }

        return $this->render('user/profil.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'credit_cards' =>$credit_cards,
            'orders' => array_reverse($orders),
            'votes' => $votes
        ]);
    }
}
