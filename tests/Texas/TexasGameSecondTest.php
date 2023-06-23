<?php

/**
 * Test suite for TexasGame class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TexasGameSecondTest extends TestCase
{
    /**
     * @var TexasGame $game Game to run tests for.
     */

    private TexasGame $game;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $deck = $this->getMockBuilder(TexasDeck::class)
            ->disableOriginalConstructor()
            ->getMock();
        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameLogic= $this->getMockBuilder(GameLogic::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameData = $this->getMockBuilder(GameData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $queue = $this->getMockBuilder(Queue::class)
            ->disableOriginalConstructor()
            ->getMock();
        $table = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->game = new TexasGame($deck, $handEvaluator, $gameLogic, $gameData, $queue, $table);
    }

    /**
     * Verifies that method returns int.
     */
    public function testGetHighestCurrentBet() : void
    {
        $res = $this->game->getHighestCurrentBet();

        $this->assertIsInt($res);
    }

    /**
     * Verifies that method returns int.
     */
    public function testGetPot() : void
    {
        $res = $this->game->getPot();

        $this->assertIsInt($res);
    }

    /**
     * Verifies that method returns int.
     */
    public function testAddMoneyToPot() : void
    {
        $res = $this->game->addMoneyToPot(10);

        $this->assertEquals(0, $res);
    }

    /**
     * Verifies that method returns int.
     */
    public function testGetBigBlind() : void
    {
        $res = $this->game->getBigBlind();

        $this->assertEquals(0, $res);
    }

    /**
     * Verifies that method returns bool.
     */
    public function testIsGameReadyForNextStage(): void
    {
        $res = $this->game->isGameReadyForNextStage();

        $this->assertFalse($res);
    }

    /**
     * Verifies that method returns PlayerInterface.
     */
    public function testGetWinner() : void
    {
        $res = $this->game->getWinner();

        $this->assertInstanceOf("App\Texas\PlayerInterFace", $res);
    }

    /**
     * Verifies that method returns array.
     */
    public function testSetFlop(): void
    {
        $res = $this->game->setFlopAndGetImages();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns array.
     */
    public function testSetTurn(): void
    {
        $res = $this->game->setTurnAndGetImages();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns bool.
     */
    public function testIsWinnerByFold(): void
    {
        $res = $this->game->isWinnerByFold();

        $this->assertFalse($res);
    }
}
