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
 * ProjectPlayerRaiseController whose routes are visited
 * when player raises.
 */

class ProjectPlayerRaiseController extends AbstractController
{
    use MessageTrait;

    /* Proj Call Route */
    #[Route('proj/player-raise', name:'proj_player_raise', methods: ['POST'])]
    public function projPlayerRaise(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var int $raiseAmount
         */
        $raiseAmount = $request->request->get('raise-amount');

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $player = $game->playerRaises($raiseAmount);

        $playerMessage = $request->request->get('message');

        $player->getPlayerMoves()->addToRoundMoves("raise");

        $messenger = $player->getName();

        $message = $playerMessage . " " . $raiseAmount;

        $this->addMessage($messenger, $message, $doctrine);

        $bRoute = $session->get('back-route');

        $session->set('game', $game);

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_reset_round');
        }

        if ($game->isGameReadyForNextStage()) {
            return $this->redirectToRoute('proj_reset_stage');
        }

        return $this->redirectToRoute($bRoute);
    }
}
