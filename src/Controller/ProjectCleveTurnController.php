<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Repository\PreFlopRankingsRepository;
use App\Texas\ComputerCleve;
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
            $game->dequeuePlayer();
            $game->enqueuePlayer($playerToAct);

            return $this->redirectToRoute($bRoute);
        }

        $holeCards = $playerToAct->getHand()->getHoleCards();

        var_dump($holeCards);
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

        $methodName = "setCleve" . ucfirst($cleveMove);

        $highestBet = $game->getHighestCurrentBet();
        $pot = $game->getPot();
        $bigBlind = $game->getBigBlind();

        $moveData = $playerToAct->setCleveMoveAndReturnData($cleveMove, $highestBet, $pot, $bigBlind);

        $playerToAct->clearRiskLevel();

        $move = ucfirst($moveData[0]);
        $amount = $moveData[1];

        $messenger = $playerToAct->getName();

        $entityManager = $doctrine->getManager();

        $message = new Messages();

        date_default_timezone_set('Europe/Stockholm');

        $currentTime = date('H:i');

        $message->setCreated(strval($currentTime));
        $message->setMessenger($messenger);
        $message->setMessage($move . " " . $amount);

        $entityManager->persist($message);

        $entityManager->flush();

        $game->dequeuePlayer();
        $game->enqueuePlayer($playerToAct);

        $session->set('game', $game);

        // REDIRECT TILL CLEVEs CONTROLLER
        return $this->redirectToRoute($bRoute);
    }
}
