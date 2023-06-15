<?php

/**
 * Test suite for GameLogic class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class GameLogicTest extends TestCase
{
    /**
     * @var GameLogic $gameLogic GameLogic class.
     */
    private GameLogic $gameLogic;

    /**
     * @var Queue $queue Queue of players.
     */
    private Queue $queue;

    public function setUp(): void
    {
        $players = [
            new TexasPlayer("Martin", 20, 20),
            new ComputerStu("Stu", 20),
            new ComputerStu("Mag", 20)
        ];

        $this->queue = new Queue($players);

        $this->gameLogic = new GameLogic();
    }

    /**
     * Verify that GameLogic object returns false for round over method.
     */
    public function testRoundOverFalse() : void
    {
        $players = $this->queue->getQueue();
        $this->assertFalse($this->gameLogic->isRoundOver($players));
    }

    /**
     * Verify that GameLogic object returns true for round over method.
     */
    public function testRoundOverTrue() : void
    {
        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            $player->getPlayerMoves()->setHasFolded();
        }

        $this->assertTrue($this->gameLogic->isRoundOver($players));
    }

    /**
     * Verify that GameLogic object returns correct integer (0) for highest bet.
     */
    public function testHighestBet() : void
    {
        $players = $this->queue->getQueue();

        $exp = 0;

        $res = $this->gameLogic->getHighestCurrentBet($players);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns false for isPlayerReady.
     */
    public function testPlayerReadyFalse() : void
    {
        $players = $this->queue->getQueue();

        $player1 = $players[0];

        $player1->addToBets(30);

        $player2 = $players[1];

        $player2->addToBets(20);

        $this->assertFalse($this->gameLogic->isPlayerReady($player2, $players));
    }

    /**
     * Verify that GameLogic object returns true for isPlayerReady when check for equal bet.
     */
    public function testPlayerReadyTrueBetEqual() : void
    {
        $players = $this->queue->getQueue();

        $player1 = $players[0];

        $player1->addToBets(30);

        $player2 = $players[1];

        $player2->addToBets(30);
        $player2->getPlayerMoves()->addToRoundMoves("call");

        $this->assertTrue($this->gameLogic->isPlayerReady($player2, $players));
    }

    /**
     * Verify that GameLogic object returns correct integer for number of folded players.
     */
    public function testFoldedPlayers() : void
    {
        $players = $this->queue->getQueue();
        $player = $players[0];
        $player->getPlayerMoves()->setHasFolded();

        $exp = 1;

        $res = $this->gameLogic->getNumberOfFoldedPlayers($players);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns true for isPlayerReady when checking for zero buy-in.
     */
    public function testGameNextStage() : void
    {
        $players = $this->queue->getQueue();

        $player1 = $players[0];

        $player1->addToBets(20);
        $player1->getPlayerMoves()->addToRoundMoves("call");

        $player2 = $players[1];

        $players[2]->getPlayerMoves()->setHasFolded();

        $player2->addToBets(30);
        $player2->getPlayerMoves()->addToRoundMoves("raise");

        $this->assertFalse($this->gameLogic->isGameReadyForNextStage($players));

        $player1->addToBets(10);
        $player1->getPlayerMoves()->addToRoundMoves("call");

        $this->assertTrue($this->gameLogic->isGameReadyForNextStage($players));
    }

    /**
     * Verify that GameLogic object returns correct number of highest actions.
     */
    public function testHighestActions() : void
    {
        $players = $this->queue->getQueue();

        $exp = 0;

        $res = $this->gameLogic->getHighestNumberOfActions($players);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns PlayerInterface.
     */
    public function testGetWinnerNoFold() : void
    {
        $players = $this->queue->getQueue();

        $exp = "App\\Texas\\PlayerInterface";

        $res = $this->gameLogic->getWinner($players);

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that GameLogic object returns PlayerInterface.
     */
    public function testGetWinner() : void
    {
        $players = $this->queue->getQueue();

        for ($i = 0; $i < 2; $i++) {
            $players[$i]->getPlayerMoves()->setHasFolded();
        }

        $exp = "App\\Texas\\PlayerInterface";

        $res = $this->gameLogic->getWinner($players);

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that GameLogic object returns PlayerInterface.
     */
    public function testGetWinnerByBestHand() : void
    {
        $players = $this->queue->getQueue();

        for ($i = 0; $i < 2; $i++) {
            $players[$i]->getHand()->setBestHandPoints(20 + $i);
        }

        $exp = "App\\Texas\\PlayerInterface";

        $res = $this->gameLogic->getWinner($players);

        $this->assertInstanceOf($exp, $res);
    }
}