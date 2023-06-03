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
// use App\Repository\MessagesRepository;
// use Doctrine\Persistence\ManagerRegistry;
use App\Texas\TexasPlayer;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TexasInitController extends AbstractController
{
//     /* Texas-init Route */
//     #[Route("/proj/texas-buyin", name: "p_texas_buyin")]
//     public function texasBuyIn(
//     ): Response {

//         return $this->render('proj/texas-init.html.twig', );
//     }
    /* Texas-init Route */
    // #[Route("/proj/texas-init", name: "p_texas_init")]
    // public function texasInit(
    // ): Response {
    //     $deck = new TexasDeck();
    //     $deck->shuffleDeck();
    //     $player = new TexasPlayer("Martin", 1000, 500);
    //     $cards = $deck->drawMany(2);

    //     $player->getHand()->setHoleCards($cards);

    //     $data = [
    //         'name' => $player->getName(),
    //         'wallet' => $player->getWallet(),
    //         'buyIn' => $player->getBuyIn(),
    //         'cards' => $player->getHand()->getHoleCardsAsStrings()
    //     ];

    //     return $this->render('proj/texas-init.html.twig', $data);
    // }

    /* Texas-init Route */
    #[Route("/proj/texas-game", name: "p_texas_game")]
    public function texasGame(
        HandEvaluator $handEvaluator,
        TexasDeck $deck,
        GameLogic $gameLogic,
        GameData $gameData
    ): Response {
        $player = new TexasPlayer("Martin", 1000, 500);
        $playerStu = new ComputerStu("Stu", 500);
        $playerCleve = new ComputerCleve("Cleve", 500);

        $players = [$player, $playerStu, $playerCleve];

        $table = new Table(500);
        $queue = new Queue($players);

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

        $game->setQueueAndRoles();
        $game->takeBlindsAndAddToPot();
        $game->dealStartingCards();
        $players = $game->getQueuePlayers();

        $data = [];

        foreach ($players as $player) {
            $name = $player->getName();
            $data[$name] = $player->getPlayerData();
        }

        return $this->render('proj/texas-game.html.twig', $data);
    }
}
