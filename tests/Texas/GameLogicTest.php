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
     * Verify that GameLogic object returns first player in queue.
     */
    public function testGetFirstInQueue() : void
    {
        $exp = "Martin";

        $res = $this->gameLogic->getFirstInQueue()->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object correctly adds player to queue.
     */
    public function testEnqueue() : void
    {
        $this->gameLogic->enqueuePlayer(new ComputerStu("Bob", 20));

        $exp = 4;

        $res = count($this->gameLogic->getPlayersInQueue());

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns correct player in queue after dequeue.
     */
    public function testDequeue() : void
    {
        $this->gameLogic->dequeuePlayer();

        $exp = "Stu";

        $res = $this->gameLogic->getFirstInQueue()->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns correct order of players.
     */
    public function testSetQueueAndGetRound() : void
    {
        $playerRoles = $this->gameLogic->setQueueBeforeRoundStart();

        $dealer = $playerRoles[0];

        $exp = "Mag";

        $res = $dealer->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns correct order of players.
     */
    public function testSetQueueAndGetCommunity() : void
    {
        $playerRoles = $this->gameLogic->shiftPlayersBeforeCommunityCards();

        $smallBlind = $playerRoles[0];

        $exp = "Martin";

        $res = $smallBlind->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameLogic object returns false for round over method.
     */
    public function testRoundOverFalse() : void
    {
        $this->assertFalse($this->gameLogic->isRoundOver());
    }

    /**
     * Verify that GameLogic object returns true for round over method.
     */
    public function testRoundOverTrue() : void
    {
        $players = $this->gameLogic->getPlayersInQueue();

        foreach ($players as $player) {
            $player->getPlayerMoves()->setHasFolded();
        }

        $this->assertTrue($this->gameLogic->isRoundOver());
    }

    /**
     * Verify that GameLogic object returns correct integer (0) for highest bet.
     */
    public function testHighestBet() : void
    {
        $exp = 0;

        $res = $this->gameLogic->getHighestCurrentBet();

        $this->assertEquals($exp, $res);
    }
}