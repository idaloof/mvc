<?php

/**
 * Test suite for TexasGame class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TexasGameFirstTest extends TestCase
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
     * Verifies that queue is array.
     */
    public function testSetQueueAndRoles() : void
    {
        $res = $this->game->setQueueAndRoles();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that blind and pot method returns pot.
     */
    public function testBlindAndPot() : void
    {
        $exp = 0;

        $res = $this->game->takeBlindsAndAddToPot();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that players have their starting cards.
     */
    public function testDealStartingCards(): void
    {
        $card1 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();

        $card1
            ->method('getCardValue')
            ->willReturn(
                "10"
            );

        $card2 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();

        $card2
            ->method('getCardValue')
            ->willReturn(
                "14"
            );

        $deck = $this->getMockBuilder(TexasDeck::class)
            ->onlyMethods(['drawMany'])
            ->disableOriginalConstructor()
            ->getMock();

        $deck
            ->method('drawMany')
            ->willReturn([
                $card1,
                $card2
            ]);

        $queue = $this->getMockBuilder(Queue::class)
            ->onlyMethods(['getQueue'])
            ->disableOriginalConstructor()
            ->getMock();

        $queue
            ->method('getQueue')
            ->willReturn([
                new TexasPlayer("Martin", 20, 20),
                new TexasPlayer("Stu", 20, 20)
            ]);

        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameLogic= $this->getMockBuilder(GameLogic::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameData = $this->getMockBuilder(GameData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $table = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table
        );

        // $this->game->method('getBets')->willReturn(14);
        $res = $game->dealStartingCards();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns array.
     */
    public function testGetPlayers(): void
    {
        $res = $this->game->getQueuePlayers();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns 3.
     */
    public function testGetPossibleMoves3(): void
    {
        $player = $this->createMock(PlayerInterface::class);
        $player->method('getBets')->willReturn(14);
        $gameLogic = $this->createMock(GameLogic::class);
        $gameLogic->method('getHighestCurrentBet')->willReturn(10);

        $exp = 3;
        $res = $this->game->getPossibleMoves($player);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that method returns PlayerInterface.
     */
    public function testDequeuePlayer() : void
    {
        $res = $this->game->dequeuePlayer();

        $this->assertInstanceOf("App\Texas\PlayerInterFace", $res);
    }

    /**
     * Verifies that method returns PlayerInterface.
     */
    public function testEnqueuePlayer() : void
    {
        $player = $this->createMock(PlayerInterface::class);

        $res = $this->game->enqueuePlayer($player);

        $this->assertInstanceOf("App\Texas\PlayerInterFace", $res);
    }

    /**
     * Verifies that method returns PlayerInterface.
     */
    public function testGetFirstPlayer() : void
    {
        $res = $this->game->getFirstPlayer();

        $this->assertInstanceOf("App\Texas\PlayerInterFace", $res);
    }

    /**
     * Verifies that method returns bool.
     */
    public function testIsRoundOver(): void
    {
        $res = $this->game->isRoundOver();

        $this->assertFalse($res);
    }
}
