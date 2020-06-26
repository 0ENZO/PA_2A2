<?php 

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $manager = $this->getDoctrine()->getManager();
        $role = $manager->getRepository(Role::class)->findOneBy(["id" => 1]);

        $user = new User();
        $user->setRole($role);

        $form = $this->createForm(UserType::class, $user);
        $form->remove("Role");

        $mdp = $form['password']->getData();
        if ($mdp != null) {
            $hashed_mdp = $passwordEncoder->encodePassword($user, $mdp);
        }


        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
//            $user->setPassword()
//            $manager->persist($user);
//            $manager->flush();
            $this->addFlash("success", "Bienvenu parmis nous !");
//            return $this->redirectToRoute("app_login");
        }

        return $this->render("security/register.html.twig", [
            "form" => $form->createView(),
            "mdp" => $mdp,
            "hashed_mdp" => $mdp
        ]);

    }

}
