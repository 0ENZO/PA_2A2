<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            
        ]);
    }
    /**
     * @Route("/blank", name="blank")
     */
    public function blank(): Response
    {
        return $this->render('home/blank.html.twig', [
            
        ]);
    }

}
