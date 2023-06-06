<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectWhatNextController extends AbstractController
{
    /* Proj What Next Route */
    #[Route("/proj/what-next", name: "proj_what_next")]
    public function projWhatNext(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_reset_round'); // RESET INFÖR NY RUNDA (SKAPA METOD I TEXASGAME)
        }

        if ($game->isGameReadyForNextStage()) {
            return $this->redirectToRoute('proj_reset_stage'); // RESET INFÖR NY STAGE (SKAPA METOD I TEXASGAME)
        }

        $bRoute = $session->get('back-route');

        $session->set('game', $game);

        return $this->redirectToRoute($bRoute);
    }
}
