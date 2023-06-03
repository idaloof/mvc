<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectWhatNextController extends AbstractController
{
    /* Proj Round over Route */
    #[Route("/proj/round-over", name: "proj_round_over")]
    public function projRoundOver(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_pre_flop'); // RESET INFÖR NY RUNDA (SKAPA METOD I TEXASGAME)
        }

        return $this->redirectToRoute('proj_next_stage');
    }

    /* Proj Round over Route */
    #[Route("/proj/next-stage", name: "proj_next-stage")]
    public function projNextStage(
        SessionInterface $session,
        Request $request
    ): Response {
        $route = $request->headers->get('referer');

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        if ($game->isGameReadyForNextRound()) {
            return $this->redirectToRoute('proj_flop');
        }

        return $this->redirectToRoute($route);
    }
}
