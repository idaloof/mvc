<?php

namespace App\Controller;

// use App\Entity\Messages;
use App\Texas\ComputerCleve;
use App\Texas\ComputerStu;
use App\Texas\GameData;
use App\Texas\GameLogic;
use App\Texas\HandEvaluator;
use App\Texas\Queue;
use App\Texas\Table;
use App\Texas\TexasDeck;
use App\Texas\TexasGame;
use App\Repository\MessagesRepository;
// use Doctrine\Persistence\ManagerRegistry;
use App\Texas\TexasPlayer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /* Proj Route */
    #[Route("/proj", name: "proj")]
    public function projLanding(
        // ManagerRegistry $doctrine,
        HandEvaluator $handEvaluator
    ): Response {
        // date_default_timezone_set('Europe/Stockholm');
        // $entityManager = $doctrine->getManager();
        // $time = (string) strval(date('H:i'));
        // $messenger = (string) "Host";
        // $newMessage = (string) "Hi, and welcome to this game of Texas Hold'em! Good luck playing!";

        // /**
        //  * @var Messages $message
        //  */

        // $message = new Messages();
        // $message->setCreated($time);
        // $message->setMessenger($messenger);
        // $message->setMessage($newMessage);

        // $entityManager->persist($message);

        // $entityManager->flush();

        $suits = ["H", "D", "C", "H", "H"];
        $values = ["9", "3", "12", "11", "10"];
        $ranks = ["9", "3", "Q", "J", "10"];

        $handData = $handEvaluator->evaluateHand($suits, $values, $ranks);

        $data = [
            "hand" => $handData[0],
            "points" => $handData[1]
        ];

        return $this->render('proj/proj.html.twig', $data);
    }

    /* Texas-init Route */
    #[Route("/proj/texas-init", name: "p_texas_init")]
    public function texasInit(
    ): Response {
        $deck = new TexasDeck();
        $deck->shuffleDeck();
        $player = new TexasPlayer("Martin", 1000, 500);
        $cards = $deck->drawMany(2);

        $player->getHand()->setHoleCards($cards);

        $data = [
            'name' => $player->getName(),
            'wallet' => $player->getWallet(),
            'buyIn' => $player->getBuyIn(),
            'cards' => $player->getHand()->getHoleCardsAsStrings()
        ];

        return $this->render('proj/texas-init.html.twig', $data);
    }

    /* Texas-init Route */
    #[Route("/proj/texas-game", name: "p_texas_game")]
    public function texas_game(
        HandEvaluator $handEvaluator,
        ManagerRegistry $registry
    ): Response
    {
        $deck = new TexasDeck();
        $gameLogic = new GameLogic();
        $gameData = new GameData();
        $player = new TexasPlayer("Martin", 1000, 500);
        $playerStu = new ComputerStu("Stu", 500);
        $playerCleve = new ComputerCleve("Cleve", 500);

        $players = [$player, $playerStu, $playerCleve];

        $table = new Table(500);
        $messageRepo = new MessagesRepository($registry);
        $queue = new Queue($players);

        $deck = new TexasDeck();
        $deck->shuffleDeck();

        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table,
            $messageRepo,
            $players
        );

        $game->setQueueAndRoles();
        $game->takeBlindsAndAddToPot();
        $game->dealStartingCards();
        $players = $game->getPlayers();

        $data = [];

        foreach ($players as $player) {
            $name = $player->getName();
            $data[$name] = $player->getPlayerData();
        }

        return $this->render('proj/texas-game.html.twig', $data);
    }
}

