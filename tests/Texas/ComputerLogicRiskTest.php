<?php

/**
 * Test suite for ComputerLogic class
 */

namespace App\Texas;

use PHPUnit\Framework\TestCase;

class ComputerLogicRiskTest extends TestCase
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
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskCheckRaise(): void
    {
        $moves = ["raise", "check"];

        $exp = -30;

        $res = $this->computerLogic->adjustRiskPlayerMoves($moves);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskCheckCall(): void
    {
        $moves = ["call", "check"];

        $exp = 80;

        $res = $this->computerLogic->adjustRiskPlayerMoves($moves);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskCheck(): void
    {
        $moves = ["check"];

        $exp = 30;

        $res = $this->computerLogic->adjustRiskPlayerMoves($moves);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskCall(): void
    {
        $moves = ["call"];

        $exp = 20;

        $res = $this->computerLogic->adjustRiskPlayerMoves($moves);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskRaised(): void
    {
        $moves = ["raise"];

        $exp = -20;

        $res = $this->computerLogic->adjustRiskPlayerMoves($moves);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskBlindAboveZero(): void
    {
        $pot = 200;
        $blind = 20;

        $exp = 30;

        $res = $this->computerLogic->adjustRiskPotAndBlind($pot, $blind);

        $this->assertEquals($exp, $res);

        $pot = 200;
        $blind = 60;

        $exp = 10;

        $res = $this->computerLogic->adjustRiskPotAndBlind($pot, $blind);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskBlindZero(): void
    {
        $pot = 300;
        $blind = 100;

        $exp = 0;

        $res = $this->computerLogic->adjustRiskPotAndBlind($pot, $blind);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskHandAboveZero(): void
    {
        $points = 400;

        $exp = 50;

        $res = $this->computerLogic->adjustRiskHandPoints($points);

        $this->assertEquals($exp, $res);

        $points = 300;

        $exp = 30;

        $res = $this->computerLogic->adjustRiskHandPoints($points);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskHandZero(): void
    {
        $points = 110;

        $exp = 10;

        $res = $this->computerLogic->adjustRiskHandPoints($points);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that correct risk adjustment is returned.
     */
    public function testAdjustRiskCardRank(): void
    {
        $rank = 10;
        $exp = 50;
        $res = $this->computerLogic->adjustRiskCardRank($rank);
        $this->assertEquals($exp, $res);

        $rank = 30;
        $exp = 40;
        $res = $this->computerLogic->adjustRiskCardRank($rank);
        $this->assertEquals($exp, $res);

        $rank = 60;
        $exp = 30;
        $res = $this->computerLogic->adjustRiskCardRank($rank);
        $this->assertEquals($exp, $res);

        $rank = 120;
        $exp = 10;
        $res = $this->computerLogic->adjustRiskCardRank($rank);
        $this->assertEquals($exp, $res);
    }
}