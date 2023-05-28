<?php

/**
 * Test suite for ComputerLogic class
 */

namespace App\Texas;

use App\Repository\PreFlopRankingsRepository;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;

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
        $registryMock = $this->getMockBuilder(ManagerRegistry::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repo = new PreFlopRankingsRepository($registryMock);

        $this->computerLogic = new ComputerLogic($repo);
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
            new Card("Ace of spades", "AS", "S", "A"),
            new Card("Ace of clubs", "AC", "C", "A")
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
            new Card("King of spades", "KS", "S", "K"),
            new Card("Ace of clubs", "AC", "C", "A")
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
            new Card("King of clubs", "KC", "C", "K"),
            new Card("Ace of clubs", "AC", "C", "A")
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
            new Card("Ace of spades", "AS", "S", "A"),
            new Card("Ace of clubs", "AC", "C", "A")
        ];

        $exp = "p";

        $res = $this->computerLogic->getHoleType($cards);

        $this->assertEquals($exp, $res);
    }
}