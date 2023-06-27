<?php

/**
 * Test suite for TexasGame class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD)
 */
class TexasGameThirdTest extends TestCase
{
    /**
     * @var TexasGame $game Game to run tests for.
     */

    private TexasGame $game;

    /**
     * @var GameLogic $gameLogic GameLogic object to run tests for.
     */

    private GameLogic $gameLogic;

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

        $this->gameLogic = $gameLogic;

        $this->game = new TexasGame($deck, $handEvaluator, $gameLogic, $gameData, $queue, $table);
    }

    /**
     * Verifies that method returns string "pre".
     */
    public function testGetPre() : void
    {
        $exp = "pre";

        $res = $this->game->getPrePostFlop();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that method returns string "post".
     */
    public function testGetPost() : void
    {
        $this->game = $this->getMockBuilder(TexasGame::class)
            ->onlyMethods(['getCommunityCards'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->game->expects($this->once())
            ->method('getCommunityCards')
            ->willReturn(['A', 'K', 'Q']);

        $exp = "post";

        $res = $this->game->getPrePostFlop();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that method returns correct Player object.
     */
    public function testGetHuman() : void
    {
        $this->game = $this->getMockBuilder(TexasGame::class)
            ->onlyMethods(['getQueuePlayers'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->game->expects($this->once())
            ->method('getQueuePlayers')
            ->willReturn([
                new TexasPlayer("Martin", 20, 20),
                new TexasPlayer("Stu", 20, 20),
                new TexasPlayer("Cleve", 20, 20)
            ]);

        $exp = "Martin";

        $res = $this->game->getHuman()->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that method returns correct bool.
     */
    public function testIsGameTiedFalse() : void
    {
        /**
         * @phpstan-ignore-next-line
         */
        $this->gameLogic->expects($this->once())
            ->method('isGameTied')
            ->willReturn(false);

        $res = $this->game->isGameTied();

        $this->assertFalse($res);
    }

    /**
     * Verifies that method returns correct bool.
     */
    public function testIsGameTiedTrue() : void
    {
        /**
         * @phpstan-ignore-next-line
         */
        $this->gameLogic->expects($this->once())
            ->method('isGameTied')
            ->willReturn(true);

        $res = $this->game->isGameTied();

        $this->assertTrue($res);
    }

    /**
     * Verifies that method returns correct bool.
     */
    public function testWinnersTieGame() : void
    {
        $res = $this->game->getWinnersTieGame();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns correct bool.
     */
    public function testSetGameData() : void
    {
        $res = $this->game->setGameData();

        $this->assertInstanceOf("App\Texas\GameData", $res);
    }

    /**
     * Verifies that method returns 2.
     */
    public function testGetPossibleMoves2(): void
    {
        $gameLogic = $this->getMockBuilder(GameLogic::class)
            ->onlyMethods(['getHighestCurrentBet'])
            ->disableOriginalConstructor()
            ->getMock();

        $gameLogic
            ->method('getHighestCurrentBet')
            ->willReturn(14);
        $deck = $this->getMockBuilder(TexasDeck::class)
            ->disableOriginalConstructor()
            ->getMock();
        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
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

        $player = $this->createMock(PlayerInterface::class);
        $player->method('getBets')->willReturn(14);

        $exp = 2;
        $res = $this->game->getPossibleMoves($player);

        $this->assertEquals($exp, $res);
    }
}
