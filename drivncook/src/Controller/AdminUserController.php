<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminUserController extends AbstractController
{

    /**
     * @Route("/user", name="admin_user_show")
     */
    public function user_show(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository(User::class)->findAll();

        $role = $em->getRepository(Role::class)->findOneByName('Client');
        $user = new User();
        $user->setRole($role);
        $form = $this->createForm(UserType::class, $user);
        $form->remove('idRole');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "Un nouvel utilisateur a été ajouté");
            return $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/user.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/edit/{id}", name="admin_user_edit")
     */
    public function user_edit(User $user, Request $request)
    {
        $form = $this->createForm(UserType::class, $user);
        $form->remove('idRole');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $this->addFlash("primary", "Un utilisateur a été modifié.");
            return $this->redirectToRoute('admin_user_show');
        }

        return $this->render('admin/User_edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/user/delete/{id}", name="admin_user_delete", methods={"GET","POST"})
     */
    public function user_delete(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        $this->addFlash("danger", "L'utilisateur que vous avez sélectionné a été supprimé.");
        return $this->redirectToRoute('admin_user_show');
    }



}
