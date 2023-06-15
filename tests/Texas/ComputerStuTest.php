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
     * Verify that ComputerStu returns correct name.
     */
    public function testReturnName() : void
    {
        $exp = "Stu";

        $res = $this->player->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu sets and returns correct buy-in amount.
     */
    public function testIncreaseAndReturnBuyIn() : void
    {
        $this->player->increaseBuyIn(20);

        $exp = 40;

        $res = $this->player->getBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu sets and returns correct buy-in amount.
     */
    public function testDecreaseAndReturnBuyIn() : void
    {
        $this->player->decreaseBuyIn(20);

        $exp = 0;

        $res = $this->player->getBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu returns correct object.
     */
    public function testReturnHand() : void
    {
        $exp = "App\Texas\TexasHand";

        $res = $this->player->getHand();

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that ComputerStu returns correct object.
     */
    public function testGetMovesObject() : void
    {
        $exp = "App\Texas\PlayerMoves";

        $res = $this->player->getPlayerMoves();

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that ComputerStu sets and returns correct betting amount.
     */
    public function testAddAndGetBets() : void
    {
        $this->player->addToBets(20);

        $exp = 20;

        $res = $this->player->getBets();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu sets and returns correct buy-in amount.
     */
    public function testClearBets() : void
    {
        $this->player->addToBets(20);

        $this->player->clearPlayerBets();

        $exp = 0;

        $res = $this->player->getBets();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu sets and returns correct role.
     */
    public function testSetAndGetRole() : void
    {
        $this->player->setRole("dealer");

        $exp = "dealer";

        $res = $this->player->getRole();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu returns correct data.
     */
    public function testGetPlayerData() : void
    {
        $exp = [
            'name' => "Stu",
            'role' => "",
            'buyIn' => 20,
            'hasFolded' => false,
            'bets' => 0,
            'holeCards' => [],
            'move' => ''
        ];

        $res = $this->player->getPlayerData();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu returns correct move data.
     */
    public function testSetAndGetMove() : void
    {
        $exp = 2;

        $res = count($this->player->setAndGetMove(2, 2, 2));

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that ComputerStu returns correct move data.
     */
    public function testSetAndGetMoveReturn() : void
    {
        $exp = 2;

        $res = count($this->player->setStuMoveAndReturnIt(2, 2, 2));

        $this->assertEquals($exp, $res);
    }
}