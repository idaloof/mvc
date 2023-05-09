<?php

namespace App\Controller;

use App\Card\Bank;
use App\Card\Deck;
use App\Card\Game;
use App\Card\Hand;
use App\Card\Player;
use App\Card\Points;
use App\Card\Rules;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    /**
     * Game instructions route
     */
    #[Route("/game", name: "game")]
    public function game(): Response
    {
        return $this->render('game/home.html.twig');
    }

    /**
     * Game init route [POST]
     */
    #[Route("/game/init", name: "game_init", methods: ['POST'])]
    public function gameInit(
        SessionInterface $session,
        Deck $deck,
        Rules $rules
    ): Response {
        $human = new Player(new Hand(), new Points());
        $bank = new Bank(new Hand(), new Points());
        $deck->shuffleDeck();
        $game = new Game($deck, $human, $bank, $rules);

        $session->set("game", $game);

        return $this->redirectToRoute('play');
    }

    /**
     * Game play route
     */
    #[Route("/game/play", name: "play")]
    public function gamePlay(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $standings = $game->getGameStandings();

        return $this->render('game/play.html.twig', $standings);
    }

    /**
     * Game hit route [POST]
     */
    #[Route("/game/hit", name: "game_hit", methods: ['POST'])]
    public function gamePlayerHit(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $game->setTurn("human");

        $standings = $game->getGameStandings();

        $session->set("game", $game);

        if ($standings["human"]["bust"]) {
            return $this->redirectToRoute('game_stop');
        }

        return $this->redirectToRoute('play');
    }

    /**
     * Game stop route [POST]
     */
    #[Route("/game/stop", name: "game_stop_post", methods: ['POST'])]
    public function gamePlayerStop(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $game->setTurn("bank");

        $session->set("game", $game);

        return $this->redirectToRoute('game_over');
    }

    /**
     * Game stop route
     */
    #[Route("/game/stop", name: "game_stop")]
    public function gamePlayerStopPost(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $game->setTurn("bank");

        $session->set("game", $game);

        return $this->redirectToRoute('game_over');
    }

    /**
     * Game over route
     */
    #[Route("/game/over", name: "game_over")]
    public function gameOver(
        SessionInterface $session
    ): Response {
        $game = $session->get("game");

        $standings = $game->getGameStandings();

        $session->set("game", $game);

        return $this->render('game/game_over.html.twig', $standings);
    }

    /**
     * Game documentation route
     */
    #[Route("/game/doc", name: "game_doc")]
    public function gameDoc(): Response
    {
        return $this->render('game/game_doc.html.twig');
    }
}
