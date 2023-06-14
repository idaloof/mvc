<?php

namespace App\Controller;

use App\Texas\MessageTrait;
use App\Texas\TexasGame;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectGameInitController extends AbstractController
{
    use MessageTrait;

    /* Proj Game Init Route */
    #[Route("/proj/game-init", name: "proj_game_init")]
    public function projGameInit(
        SessionInterface $session,
        ManagerRegistry $doctrine,
        Connection $connection
    ): Response {

        /**
         * @var TexasGame $game
         */
        $game = $session->get('game');

        $game->setQueueAndRoles();
        $game->takeBlindsAndAddToPot();
        $game->dealStartingCards();

        $session->set('game', $game);

        $sql = [
            'DROP TABLE IF EXISTS messages;',
            'CREATE TABLE messages (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                created VARCHAR(5) NOT NULL,
                messenger VARCHAR(255) NOT NULL,
                "message" VARCHAR(255) NOT NULL
            );'
        ];

        foreach ($sql as $query) {
            $statement = $connection->prepare($query);
            $statement->executeStatement();
        }

        $messenger = "Texas";
        $message = "Limit Texas Hold'em! Nu kör vi.";

        $this->addMessage($messenger, $message, $doctrine);

        return $this->redirectToRoute('proj_pre_flop');
    }
}
