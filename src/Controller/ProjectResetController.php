<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectResetController extends AbstractController
{
    /* Proj Reset Stage Route */
    #[Route("/proj/reset-stage", name: "proj_reset_stage")]
    public function projResetStage(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $game->resetForNextStage();

        $fRoute = $session->get('forward-route');

        $session->set('game', $game);

        return $this->redirectToRoute($fRoute);
    }

    /* Proj Reset Round Route */
    #[Route("/proj/reset-round", name: "proj_reset_round")]
    public function projResetRound(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $game->resetForNewRound();

        $session->set('game', $game);

        return $this->redirectToRoute('proj_pre_flop');
    }
}
