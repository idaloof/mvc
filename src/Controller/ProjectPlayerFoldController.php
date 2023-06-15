<?php

namespace App\Controller;

use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ProjectPlayerCallController whose routes are visited
 * when player folds.
 */

class ProjectPlayerFoldController extends AbstractController
{
    use MessageTrait;

    /* Proj Fold Route */
    #[Route('proj/player-fold', name:'proj_player_fold', methods: ['POST'])]
    public function projPlayerCheck(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $player = $game->playerFolds();

        $playerMessage = $request->request->get('message');

        $player->getPlayerMoves()->addToRoundMoves("fold");

        $messenger = $player->getName();

        $message = (string) $playerMessage;

        $this->addMessage($messenger, $message, $doctrine);

        // $bRoute = $session->get('back-route');

        $session->set('game', $game);

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_reset_round');
        }

        if ($game->isGameReadyForNextStage()) {
            return $this->redirectToRoute('proj_complay');
        }

        return $this->redirectToRoute('proj_complay');
    }
}
