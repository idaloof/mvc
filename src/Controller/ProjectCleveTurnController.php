<?php

namespace App\Controller;

use App\Repository\PreFlopRankingsRepository;
use App\Texas\ComputerCleve;
use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * ProjectCleveTurnController whose route is visited
 * when it is ComputerCleve's turn.
 */

class ProjectCleveTurnController extends AbstractController
{
    use MessageTrait;
    /* Proj Cleve Turn Route */
    #[Route('proj/cleve-turn', name:'proj_cleve_turn')]
    public function projCleveTurn(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        PreFlopRankingsRepository $flopRepo
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
         * @var ComputerCleve $playerToAct
         */
        $playerToAct = $game->getFirstPlayer();

        if ($playerToAct->getPlayerMoves()->hasFolded()) {
            $player = $game->dequeuePlayer();
            $game->enqueuePlayer($player);

            return $this->redirectToRoute($bRoute);
        }

        $holeCards = $playerToAct->getHand()->getHoleCards();

        $type = $playerToAct->getHoleType($holeCards);
        $ranks = $playerToAct->getHoleRanks($holeCards);

        $cardCombo = $flopRepo->findCardRanking($ranks, $type)[0];

        /**
         * @var int $cardRank
         */
        $cardRank = intval($cardCombo->getRank());

        $riskLevel = $playerToAct->adjustRiskCardRank($cardRank);

        $stage = $game->getPrePostFlop();
        $riskLevel += $game->setCleveRiskLevel($stage, $playerToAct);
        $moves = $game->getPossibleMoves($playerToAct);

        $methodName = "setAndGetCleveMove" . ucfirst($stage);

        $cleveMove = $playerToAct->$methodName($riskLevel, $moves);

        $highestBet = $game->getHighestCurrentBet();
        $bigBlind = $game->getBigBlind();

        $moveData = $playerToAct->setCleveMoveAndReturnData($cleveMove, $highestBet, $bigBlind);

        if ($moveData[0] === "call" || $moveData[0] === "raise") {
            $game->addMoneyToPot($moveData[1]);
        }

        $playerToAct->clearRiskLevel();

        $move = ucfirst($moveData[0]);
        $amount = $moveData[1];

        $messenger = $playerToAct->getName();

        $message = $move . " " . $amount;

        $this->addMessage($messenger, $message, $doctrine);

        $game->dequeuePlayer();
        $game->enqueuePlayer($playerToAct);

        $session->set('game', $game);

        return $this->redirectToRoute($bRoute);
    }
}
