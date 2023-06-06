<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectFlopController extends AbstractController
{
    /* Proj PreFlop Route */
    #[Route("/proj/flop", name: "proj_flop")]
    public function projPreFlop(
        SessionInterface $session,
        MessagesRepository $repository
    ): Response {
        $session->set('forward-route', 'proj_turn_init');
        $session->set('back-route', 'proj_flop');

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

        $queuePlayers = $game->getQueuePlayers();

        $playerToAct = $game->getFirstPlayer();

        if ($playerToAct->getPlayerMoves()->hasFolded()) {
            $game->dequeuePlayer();
            $game->enqueuePlayer($playerToAct);

            return $this->redirectToRoute('proj_flop');
        }

        if ($playerToAct->getName() === "Stu") {
            return $this->redirectToRoute('proj_stu_turn');
        }

        if ($playerToAct->getName() === "Cleve") {
            return $this->redirectToRoute('proj_cleve_turn');
        }

        $queuePlayersData = [];

        foreach ($queuePlayers as $player) {
            $queuePlayersData[] = $player->getPlayerData();
        }

        $messages = $repository->findAll();

        // TA FRAM HUR MÅNGA MOVES SPELAREN KAN GÖRA
        $player = $game->getFirstPlayer();

        $possibleMoves = $game->getPossibleMoves($player);

        // Beräkna hur mycket för call samt (METOD???)
        // min och max raise utifrån spelarens bet, pot och högsta bet.
        $highestBet = $game->getHighestCurrentBet();
        $pot = $game->getPot();

        $callSize = $highestBet - $player->getBets();
        $maxRaise = $callSize + $pot;
        $minRaise = $callSize + $game->getBigBlind();

        $session->set('game', $game);
        $communityImages = $session->get('communityImages');

        return $this->render('proj/proj-flop.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'messages' => $messages,
            'moves' => $possibleMoves,
            'call' => $callSize,
            'maxRaise' => $maxRaise,
            'minRaise' => $minRaise,
            'callUrl' => $this->generateUrl('proj_player_call'),
            'raiseUrl' => $this->generateUrl('proj_player_raise'),
            'community' => $communityImages
        ]);
    }
}