<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasicRoutes extends AbstractController
{
    /* Home Route */
    #[Route("/", name: "/")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    /* About Route */
    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    /* Report Route */
    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }
}