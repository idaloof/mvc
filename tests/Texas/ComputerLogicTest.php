<?php

/**
 * Test suite for ComputerLogic class
 */

namespace App\Texas;

use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD)
 */
class ComputerLogicTest extends TestCase
{
    /**
     * @var ComputerLogic $computerLogic ComputerLogic object to run tests for.
     */

    private ComputerLogic $computerLogic;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->computerLogic = new ComputerLogic();
    }

    /**
     * Verify that ComputerLogic object returns true for running low.
     */
    public function testIsRunningLowTrue() : void
    {
        $initial = 1000;

        $mockPlayer = $this->getMockBuilder(PlayerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPlayer->expects($this->any())
            ->method('getBuyIn')
            ->willReturn(290);

        $this->assertTrue($this->computerLogic->isRunningLow($mockPlayer, $initial));
    }

    /**
     * Verify that ComputerLogic object returns false for running low.
     */
    public function testIsRunningLowFalse() : void
    {
        $initial = 1000;

        $mockPlayer = $this->getMockBuilder(PlayerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockPlayer->expects($this->any())
            ->method('getBuyIn')
            ->willReturn(400);

        $this->assertFalse($this->computerLogic->isRunningLow($mockPlayer, $initial));
    }

    /**
     * Verifies that correct card ranks are returned.
     */
    public function testGetHoleRanks(): void
    {
        $cards = [
            new Card("Ace of spades", "AS", "S", "A", "14"),
            new Card("Ace of clubs", "AC", "C", "A", "14")
        ];

        $exp = "AA";

        $res = $this->computerLogic->getHoleRanks($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct card combo type is returned.
     */
    public function testGetHoleTypeOffSuit(): void
    {
        $cards = [
            new Card("King of spades", "KS", "S", "K", "13"),
            new Card("Ace of clubs", "AC", "C", "A", "14")
        ];

        $exp = "o";

        $res = $this->computerLogic->getHoleType($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct card combo type is returned.
     */
    public function testGetHoleTypeSuited(): void
    {
        $cards = [
            new Card("King of clubs", "KC", "C", "K", "13"),
            new Card("Ace of clubs", "AC", "C", "A", "14")
        ];

        $exp = "s";

        $res = $this->computerLogic->getHoleType($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct card combo type is returned.
     */
    public function testGetHoleTypePair(): void
    {
        $cards = [
            new Card("Ace of spades", "AS", "S", "A", "14"),
            new Card("Ace of clubs", "AC", "C", "A", "14")
        ];

        $exp = "p";

        $res = $this->computerLogic->getHoleType($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct number of elements exist in returned array.
     */
    public function testStuMoveReturnArrayTwo(): void
    {
        $player = $this->createMock(PlayerInterface::class);

        $moves = 2;
        $callSize = 20;
        $minRaise = 20;

        $computerLogic = new ComputerLogic();
        $result = $computerLogic->setAndGetStuMove($player, $moves, $callSize, $minRaise);

        $exp = 2;

        $res = count($result);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct array is returned.
     */
    public function testStuFoldsCorrectArray(): void
    {
        $player = $this->createMock(PlayerInterface::class);

        $computerLogic = new ComputerLogic();
        $result = $computerLogic->wrapperStuFolds($computerLogic, $player, 14, 14);

        $this->assertEquals(["fold", ""], $result);
    }

    /**
     * Verifies that correct array is returned.
     */
    public function testStuChecksCorrectArray(): void
    {
        $player = $this->createMock(PlayerInterface::class);

        $computerLogic = new ComputerLogic();
        $result = $computerLogic->wrapperStuChecks($computerLogic, $player, 14, 14);

        $this->assertEquals(["check", ""], $result);
    }

    /**
     * Verifies that correct array is returned.
     */
    public function testStuCallsCorrectArray(): void
    {
        $player = $this->createMock(PlayerInterface::class);

        $computerLogic = new ComputerLogic();

        $callSize = 20;
        $minRaise = 20;

        $result = $computerLogic->wrapperStuCalls(
            $computerLogic,
            $player,
            $callSize,
            $minRaise
        );

        $this->assertEquals(["call", 20], $result);
    }

    /**
     * Verifies that correct array is returned.
     */
    public function testStuRaisesCorrectArray(): void
    {
        $player = $this->createMock(PlayerInterface::class);

        $computerLogic = new ComputerLogic();

        $callSize = 20;
        $minRaise = 20;

        $result = $computerLogic->wrapperStuRaises(
            $computerLogic,
            $player,
            $callSize,
            $minRaise
        );

        $this->assertGreaterThanOrEqual(20, $result[1]);
    }
}