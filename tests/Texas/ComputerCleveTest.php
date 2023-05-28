<?php

/**
 * Test suite for ComputerCleve class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class ComputerCleveTest extends TestCase
{
    /**
     * @var ComputerCleve $player Player to run tests for.
     */

    private ComputerCleve $player;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->player = new ComputerCleve("Cleve", 20);
    }

    /**
     * Verifies that correct object is instantiated.
     */
    protected function testCreateObject() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $this->assertInstanceOf("App\Texas\ComputerStu", $player);
    }

    /**
     * Verify that ComputerCleve increases and returns correct risk level.
     */
    public function testIncreaseAndGetRisk() : void
    {
        $this->player->adjustRiskLevel(20);

        $exp = 20;

        $res = $this->player->getRiskLevel();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerCleve decreases and returns correct risk level.
     */
    public function testDecreaseAndGetRisk() : void
    {
        $this->player->adjustRiskLevel(-20);

        $exp = -20;

        $res = $this->player->getRiskLevel();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerCleve decreases and returns correct risk level.
     */
    public function testClearAndGetRisk() : void
    {
        $this->player->adjustRiskLevel(-20);
        $this->player->clearRiskLevel();

        $exp = 0;

        $res = $this->player->getRiskLevel();

        $this->assertEquals($exp, $res);
    }
}