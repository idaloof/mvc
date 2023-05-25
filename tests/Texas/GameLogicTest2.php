<?php

/**
 * Test suite nr 2 for GameLogic class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class GameLogicTest2 extends TestCase
{
    /**
     * @var GameLogic $gameLogic GameLogic class.
     */
    private GameLogic $gameLogic;

    public function setUp(): void
    {
        $players = [
            new TexasPlayer("Martin", 20, 20),
            new ComputerStu("Stu", 20),
            new ComputerStu("Mag", 20)
        ];

        $queue = new Queue($players);

        $this->gameLogic = new GameLogic($queue);
    }

    /**
     * Verify that GameLogic object returns false for isPlayerReady.
     */
    public function testPlayerReadyFalse() : void
    {
        $players = $this->gameLogic->getPlayersInQueue();

        $player1 = $players[0];

        $player1->addToBets(30);

        $player2 = $players[1];

        $player2->addToBets(20);

        $this->assertFalse($this->gameLogic->isPlayerReady($player2));
    }

    /**
     * Verify that GameLogic object returns true for isPlayerReady when check for equal bet.
     */
    public function testPlayerReadyTrueBetEqual() : void
    {
        $players = $this->gameLogic->getPlayersInQueue();

        $player1 = $players[0];

        $player1->addToBets(30);

        $player2 = $players[1];

        $player2->addToBets(30);

        $this->assertTrue($this->gameLogic->isPlayerReady($player2));
    }

    /**
     * Verify that GameLogic object returns true for isPlayerReady when checking for zero buy-in.
     */
    public function testPlayerReadyTrueZeroBuyIn() : void
    {
        $players = $this->gameLogic->getPlayersInQueue();

        $player1 = $players[0];

        $player1->addToBets(20);
        $player1->decreaseBuyIn(20);

        $player2 = $players[1];

        $player2->addToBets(30);

        $this->assertTrue($this->gameLogic->isPlayerReady($player1));
    }

    /**
     * Verify that GameLogic object returns correct integer for number of folded players.
     */
    public function testFoldedPlayers() : void
    {
        $players = $this->gameLogic->getPlayersInQueue();
        $player = $players[0];
        $player->getPlayerMoves()->setHasFolded();

        $exp = 1;

        $res = $this->gameLogic->getNumberOfFoldedPlayers();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns true for isPlayerReady when checking for zero buy-in.
     */
    public function testGameNextStage() : void
    {
        $players = $this->gameLogic->getPlayersInQueue();

        $player1 = $players[0];

        $player1->addToBets(20);

        $player2 = $players[1];

        $players[2]->getPlayerMoves()->setHasFolded();

        $player2->addToBets(30);

        $this->assertFalse($this->gameLogic->isGameReadyForNextStage());

        $player1->addToBets(10);

        $this->assertTrue($this->gameLogic->isGameReadyForNextStage());
    }
}