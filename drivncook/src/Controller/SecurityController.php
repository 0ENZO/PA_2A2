<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Franchise;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/modification_mdp", name="app_password_change")
     */
    public function change_user_password(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em) 
    {

        if ($request->isMethod('POST')) {
            $user = $this->getUser();
            $passwordOld = $request->request->get('passwordOld');
            $passwordNew = $request->request->get('passwordNew');
            $passwordNewConfirm = $request->request->get('passwordNewConfirm');

            if (!$passwordEncoder->isPasswordValid($user, $passwordOld)) {
                $this->addFlash('warning', 'Mot de passe erroné');
                return $this->redirectToRoute($request->get('_route')); 
            }

            if ($passwordNew != $passwordNewConfirm) {
                $this->addFlash('warning', 'Les mots de passe ne correspondent pas');
                return $this->redirectToRoute($request->get('_route'));
            }

            $user->setPassword($passwordEncoder->encodePassword($user, $passwordNew));
            $em->persist($user);
            $em->flush();
            $this->addFlash('info', 'Mot de passe modifié');
            
            if($user instanceof User)
                return $this->redirectToRoute('user_profil');
            elseif ($user instanceof Franchise)
                return $this->redirectToRoute('franchise_profil');
        }
        return $this->render('security/password_change.html.twig');
    }

}
