<?php

namespace App\Controller;

use App\Texas\GameData;
use App\Texas\GameLogic;
use App\Texas\HandEvaluator;
use App\Texas\PlayerInterface;
use App\Texas\Queue;
use App\Texas\Table;
use App\Texas\TexasDeck;
use App\Texas\TexasGame;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectCreateGameController extends AbstractController
{
    /* Proj Create Game Route */
    #[Route("/proj/create-game", name: "proj_create_game")]
    public function projCreateGame(
        SessionInterface $session,
        HandEvaluator $handEvaluator,
        GameLogic $gameLogic,
        GameData $gameData
    ): Response {

        /**
         * @var array<PlayerInterface> $players
         */
        $players = $session->get('players');
        $buyin = $session->get('buyin');

        $queue = new Queue($players);
        $table = new Table($buyin);

        $deck = new TexasDeck();

        $deck->shuffleDeck();

        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table,
            $players
        );

        $session->set('game', $game);

        return $this->redirectToRoute('proj_game_init');
    }
}
