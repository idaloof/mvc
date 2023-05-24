<?php

/**
 * Test suite for ComputerStu class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class ComputerStuTest extends TestCase
{
    /**
     * @var ComputerStu $player Player to run tests for.
     */

    private ComputerStu $player;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->player = new ComputerStu("Stu", 20);
    }

    /**
     * Verify that TexasPlayer returns correct name.
     */
    public function testCardReturnName() : void
    {
        $exp = "Stu";

        $res = $this->player->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct buy-in amount.
     */
    public function testCardIncreaseAndReturnBuyIn() : void
    {
        $this->player->increaseBuyIn(20);

        $exp = 40;

        $res = $this->player->getBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct buy-in amount.
     */
    public function testCardDecreaseAndReturnBuyIn() : void
    {
        $this->player->decreaseBuyIn(20);

        $exp = 0;

        $res = $this->player->getBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer returns correct object.
     */
    public function testCardReturnHand() : void
    {
        $exp = "App\Texas\TexasHand";

        $res = $this->player->getHand();

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that TexasPlayer returns correct object.
     */
    public function testCardReturnBet() : void
    {
        $exp = "App\Texas\Bet";

        $res = $this->player->getBet();

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that TexasPlayer setHasFolded sets correct bool.
     */
    public function testSetHasFolded() : void
    {
        $this->player->setHasFolded();

        $this->assertTrue($this->player->hasFolded());
    }

    /**
     * Verify that TexasPlayer hasFolded returns correct bool.
     */
    public function testHasFolded() : void
    {
        $this->assertFalse($this->player->hasFolded());
    }
}