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
}