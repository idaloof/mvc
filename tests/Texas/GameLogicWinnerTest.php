<?php

/**
 * Test suite for GameLogic class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class GameLogicWinnerTest extends TestCase
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
     * @SuppressWarnings(PHPMD)
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

    /**
     * Verify that GameLogic object returns correct bool.
     */
    public function testGameTiedFalse() : void
    {
        $players = $this->queue->getQueue();

        for ($i = 0; $i < 2; $i++) {
            $players[$i]->getHand()->setBestHandPoints(20 + $i);
        }

        $res = $this->gameLogic->isGameTied($players);

        $this->assertFalse($res);
    }

    /**
     * Verify that GameLogic object returns correct bool.
     */
    public function testGameTiedTrue() : void
    {
        $players = $this->queue->getQueue();

        $players[1]->getPlayerMoves()->setHasFolded();

        for ($i = 0; $i < 3; $i++) {
            if (!$players[$i]->getPlayerMoves()->hasFolded()) {
                $players[$i]->getHand()->setBestHandPoints(20);
            }
        }

        $res = $this->gameLogic->isGameTied($players);

        $this->assertTrue($res);
    }

    /**
     * Verify that GameLogic object returns correct bool.
     */
    public function testGetTieWinners() : void
    {
        $players = $this->queue->getQueue();

        $players[0]->getPlayerMoves()->setHasFolded();

        $exp = 2;

        $res = count($this->gameLogic->getTiedWinners($players));

        $this->assertEquals($exp, $res);
    }
}