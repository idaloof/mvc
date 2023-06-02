<?php

namespace App\Controller;

use App\Repository\MessagesRepository;
use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectPreFlopController extends AbstractController
{
    /* Proj PreFlop Route */
    #[Route("/proj/pre-flop", name: "proj_pre_flop")]
    public function projCreateGame(
        SessionInterface $session,
        MessagesRepository $repository
    ): Response {

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $queuePlayers = $game->getQueuePlayers();

        // KOLLA OM SPELET KAN GÅ VIDARE TILL NÄSTA RUNDA, I SÅ FALL:
        //      --> REDIRECT TILL SIDA SOM STÄLLER OM RELEVANT DATA
        //      --> SKIFTAR KÖN
        //      --> DELAR UT COMMUNITY CARDS
        //      --> REDIRECT TILL NÄSTA STAGE CONTROLLER
        // ANNARS:
        //      --> NÄSTA IF-SATS NEDAN

        // KOLLA OM FÖRSTA SPELAREN I KÖN HAR FOLDAT, I SÅ FALL:
        //      --> SKIFTA KÖN
        // ANNARS:
        //      --> RENDERA SIDAN

        $queuePlayersData = [];

        foreach ($queuePlayers as $player) {
            $queuePlayersData[] = $player->getPlayerData();
        }

        $messages = $repository->findAll();

        // TA FRAM HUR MÅNGA MOVES SPELAREN KAN GÖRA
        $player = $game->dequeuePlayer();
        $game->enqueuePlayer($player);

        $possibleMoves = $game->getPossibleMoves($player);

        // Beräkna hur mycket för call samt
        // min och max raise utifrån spelarens bet, pot och högsta bet.
        $highestBet = $game->getHighestCurrentBet();
        $pot = $game->getPot();

        $callSize = $highestBet - $player->getBets();
        $maxRaise = $callSize + $pot;
        $minRaise = $callSize + $game->getBigBlind();

        return $this->render('proj/proj-pre-flop.html.twig', [
            'queuePlayers' => $queuePlayersData,
            'messages' => $messages,
            'moves' => $possibleMoves,
            'call' => $callSize,
            'maxRaise' => $maxRaise,
            'minRaise' => $minRaise,
        ]);
    }
}
