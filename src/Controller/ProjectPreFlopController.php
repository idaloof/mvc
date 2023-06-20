<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use App\Texas\MessageTrait;
use App\Texas\MoneyHandler;
use App\Texas\TexasGame;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectPreFlopController extends AbstractController
{
    use MessageTrait;
    use MoneyHandler;
    /* Proj PreFlop Route */
    #[Route("/proj/pre-flop", name: "proj_pre_flop")]
    public function projPreFlop(
        SessionInterface $session,
        MessagesRepository $repository,
        ManagerRegistry $doctrine
    ): Response {
        $session->set('forward-route', 'proj_flop_init');
        $session->set('back-route', 'proj_pre_flop');

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

        $buyIn = $session->get('buyin');

        $this->fillComPlayersBuyIn($queuePlayers, $buyIn, $doctrine);

        $playerToAct = $game->getFirstPlayer();

        if ($playerToAct->getPlayerMoves()->hasFolded()) {
            $game->dequeuePlayer();
            $game->enqueuePlayer($playerToAct);

            return $this->redirectToRoute('proj_pre_flop');
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
        $minRaise = $game->getBigBlind();

        $session->set('game', $game);

        return $this->render('proj/proj-pre-flop.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'messages' => $messages,
            'moves' => $possibleMoves,
            'call' => $callSize,
            'minRaise' => $minRaise,
            'pot' => $pot,
            'callUrl' => $this->generateUrl('proj_player_call'),
            'raiseUrl' => $this->generateUrl('proj_player_raise'),
            'checkUrl' => $this->generateUrl('proj_player_check'),
            'foldUrl' => $this->generateUrl('proj_player_fold')
        ]);
    }
}
