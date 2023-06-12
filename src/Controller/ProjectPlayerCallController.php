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
 * when player calls.
 */

class ProjectPlayerCallController extends AbstractController
{
    use MessageTrait;

    /* Proj Call Route */
    #[Route('proj/player-call', name:'proj_player_call', methods: ['POST'])]
    public function projPlayerCall(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var int $callAmount
         */
        $callAmount = $request->request->get('call-amount');

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $player = $game->playerCalls($callAmount);

        $playerMessage = $request->request->get('message');

        $player->getPlayerMoves()->addToRoundMoves("call");

        $messenger = $player->getName();

        $message = $playerMessage . " " . $callAmount;

        $this->addMessage($messenger, $message, $doctrine);

        $session->set('game', $game);
        $bRoute = $session->get('back-route');

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_reset_round');
        }

        if ($game->isGameReadyForNextStage()) {
            return $this->redirectToRoute('proj_reset_stage');
        }

        return $this->redirectToRoute($bRoute);
    }
}
