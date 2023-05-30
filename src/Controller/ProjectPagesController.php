<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectPagesController extends AbstractController
{
    /* Proj Landing Route */
    #[Route("/proj", name: "proj")]
    public function proj(
        SessionInterface $session
    ): Response {
        $session->invalidate();

        return $this->render('proj/proj.html.twig');
    }

    /* Proj About Route */
    #[Route("/proj/about", name: "proj_about")]
    public function projAbout(
    ): Response {

        return $this->render('proj/about.html.twig');
    }

    /* Proj Database Route */
    #[Route("/proj/about/database", name: "proj_database")]
    public function projDatabase(
    ): Response {

        return $this->render('proj/database.html.twig');
    }
}
