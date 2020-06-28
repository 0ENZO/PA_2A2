<?php 

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Truck;
use App\Repository\TruckRepository;
use App\Repository\FranchiseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;



/**
 * @Route("/camion")
 */
class TruckController extends AbstractController
{

    /**
     * @Route("/assigner/{idTruck}", name="assign_truck", requirements={"idTruck"="\d+"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function assign($idTruck, TruckRepository $truckRepository, FranchiseRepository $franchiseRepository, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $truck = $truckRepository->findOneById($idTruck);
        
        if(!$truck->getFranchise()){

            $choices = $franchiseRepository->findAll();

            $form = $this->createFormBuilder()
            ->add('franchise', EntityType::class, array(
                'class' => Franchise::class,
                'choices' => $choices,
                'choice_label' => function ($value, $key, $index) {
                    return $value;
                    // return strtoupper($key);
                    // or if you want to translate some key
                    //return 'form.choice.'.$key;
                },
            ))
            ->getForm();
    
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
    
                $selected = $form->get('franchise')->getData();
                $truck->setFranchise($selected);
                $truck->setStatus('Occupé');
                $em->persist($truck);
                $em->flush();
    
                $this->addFlash('info', "Camion assigné.");
                return $this->redirectToRoute('admin_truck_show');
            }
            
            return $this->render('admin/truck/assign.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $this->addFlash('warning', "Ce camion est déjà assigné.");
        return $this->redirectToRoute('admin_truck_show');

    }
}