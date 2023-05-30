<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectCreateMoreController extends AbstractController
{
    /* Proj Post Route */
    #[Route("/proj/create-game", name: "proj_create_game")]
    public function projCreateGame(
        SessionInterface $session,
    ): Response {

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        return $this->render('proj/proj-pre-flop.html.twig');
    }
}
