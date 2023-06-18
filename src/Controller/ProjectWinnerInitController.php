<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectWinnerInitController extends AbstractController
{
    /* Proj Winner Init Route */
    #[Route("/proj/winner-init", name: "proj_winner_init")]
    public function projWinnerInit(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        if ($game->isGameTied()) {
            return $this->redirectToRoute('proj_winner_tie');
        }

        return $this->redirectToRoute('proj_winner');
    }
}
