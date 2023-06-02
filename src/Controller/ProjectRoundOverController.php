<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectRoundOverController extends AbstractController
{
    /* Proj Round over Route */
    #[Route("/proj/round-over", name: "proj_round_over")]
    public function projCheckRoundOver(
        SessionInterface $session,
        Request $request
    ): Response {
        $route = $request->headers->get('referer');

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_pre_flop');
        }

        return $this->redirectToRoute($route);
    }
}
