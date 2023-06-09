<?php

namespace App\Controller;

use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectWinnerController extends AbstractController
{
    /* Proj Winner Route */
    #[Route("/proj/winner", name: "proj_winner")]
    public function projWinner(
        SessionInterface $session
    ): Response {
        /**
         * @var TexasGame $game
         */

        $session->set('forward-route', 'proj_reset_round');
        $session->set('back-route', 'proj_winner');

        $game = $session->get('game');

        $queuePlayers = $game->getQueuePlayers();

        $queuePlayersData = [];

        foreach ($queuePlayers as $player) {
            $queuePlayersData[] = $player->getPlayerData();
        }

        $pot = $game->getPot();

        $winner = $game->getWinner();

        $winnerName = $winner->getName();
        $winnerHandName = $winner->getHand()->getBestHandName();
        $winnerCards = $winner->getHand()->getBestHandAsImages();

        $gameData = $game->setGameData();

        $gameData->setRoundWinner($winner);
        $gameData->setRoundWinnerHand($winner->getHand()->getBestHand());

        $communityImages = $session->get('communityImages');
        $session->set('game', $game);

        return $this->render('proj/proj-winner.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'restartUrl' => $this->generateUrl('proj_reset_round'),
            'manageWalletUrl' => $this->generateUrl('proj_wallet_manage'),
            'community' => $communityImages,
            'pot' => $pot,
            'winner' => $winnerName,
            'winnerHand' => $winnerHandName,
            'winnerCards' => $winnerCards
        ]);
    }

    /* Proj Winner Tie Route */
    #[Route("/proj/winner-tie", name: "proj_winner_tie")]
    public function projWinnerTie(
        SessionInterface $session
    ): Response {
        $session->set('forward-route', 'proj_reset_round_tie');
        $session->set('back-route', 'proj_winner_tie');

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $queuePlayers = $game->getQueuePlayers();

        $queuePlayersData = [];

        foreach ($queuePlayers as $player) {
            $queuePlayersData[] = $player->getPlayerData();
        }

        $pot = $game->getPot();

        $winners = $game->getWinnersTieGame();

        $bestHand = $winners[0]->getHand()->getBestHandName();

        $winnerNames = "";

        foreach ($winners as $player) {
            $winnerNames .= $player->getName() . ", ";
        }

        $communityImages = $session->get('communityImages');
        $session->set('game', $game);

        return $this->render('proj/proj-winner-tie.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'restartUrl' => $this->generateUrl('proj_reset_round_tie'),
            'manageWalletUrl' => $this->generateUrl('proj_wallet_manage'),
            'community' => $communityImages,
            'pot' => $pot,
            'winner' => $winnerNames,
            'bestHand' => $bestHand
        ]);
    }
}
