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

        $winning = "hand";

        if ($game->isWinnerByFold()) {
            $winning = "fold";
        }

        $communityImages = $session->get('communityImages');
        $session->set('game', $game);

        return $this->render('proj/proj-winner.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'restartUrl' => $this->generateUrl('proj_reset_round'),
            'community' => $communityImages,
            'pot' => $pot,
            'winner' => $winnerName,
            'winnerHand' => $winnerHandName,
            'winnerCards' => $winnerCards,
            'winning' => $winning
        ]);
    }
}
