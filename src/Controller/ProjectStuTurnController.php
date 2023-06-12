<?php

namespace App\Controller;

use App\Texas\ComputerStu;
use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ProjectStuTurnController whose route is visited
 * when it is ComputerStu's turn.
 */

class ProjectStuTurnController extends AbstractController
{
    use MessageTrait;

    /* Proj Stu Turn Route */
    #[Route('proj/stu-turn', name:'proj_stu_turn')]
    public function projStuTurn(
        SessionInterface $session,
        ManagerRegistry $doctrine
    ): Response {
        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        if ($game->isRoundOver()) {
            return $this->redirectToRoute('proj_reset_round');
        }

        if ($game->isGameReadyForNextStage()) {
            return $this->redirectToRoute('proj_reset_stage');
        }

        $bRoute = $session->get('back-route');

        /**
         * @var ComputerStu $playerToAct
         */
        $playerToAct = $game->getFirstPlayer();

        if ($playerToAct->getPlayerMoves()->hasFolded()) {
            $game->dequeuePlayer();
            $game->enqueuePlayer($playerToAct);

            return $this->redirectToRoute($bRoute);
        }

        // SÄTT STU MOVE
        $moveData = $game->setStuMoveAndReturnIt($playerToAct);

        if ($moveData[0] === "call" || $moveData[0] === "raise") {
            $game->addMoneyToPot($moveData[1]);
        }

        $move = ucfirst($moveData[0]);
        $amount = $moveData[1];

        $messenger = $playerToAct->getName();

        $message = $move . " " . $amount;

        $this->addMessage($messenger, $message, $doctrine);

        $game->dequeuePlayer();
        $game->enqueuePlayer($playerToAct);

        $session->set('game', $game);

        // REDIRECT TILL CLEVEs CONTROLLER
        return $this->redirectToRoute($bRoute);
    }
}
