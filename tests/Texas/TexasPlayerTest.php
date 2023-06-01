<?php

/**
 * Test suite for TexasPlayer class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD)
 */
class TexasPlayerTest extends TestCase
{
    /**
     * @var TexasPlayer $player Player to run tests for.
     */

    private TexasPlayer $player;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->player = new TexasPlayer("Martin", 20, 20);
    }

    /**
     * Verify that TexasPlayer returns correct name.
     */
    public function testReturnName() : void
    {
        $exp = "Martin";

        $res = $this->player->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct wallet amount.
     */
    public function testIncreaseAndReturnWallet() : void
    {
        $this->player->increaseWallet(20);

        $exp = 40;

        $res = $this->player->getWallet();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct wallet amount.
     */
    public function testDecreaseAndReturnWallet() : void
    {
        $this->player->decreaseWallet(20);

        $exp = 0;

        $res = $this->player->getWallet();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct buy-in amount.
     */
    public function testIncreaseAndReturnBuyIn() : void
    {
        $this->player->increaseBuyIn(20);

        $exp = 40;

        $res = $this->player->getBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct buy-in amount.
     */
    public function testDecreaseAndReturnBuyIn() : void
    {
        $this->player->decreaseBuyIn(20);

        $exp = 0;

        $res = $this->player->getBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer returns correct object.
     */
    public function testReturnHand() : void
    {
        $exp = "App\Texas\TexasHand";

        $res = $this->player->getHand();

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that TexasPlayer returns correct object.
     */
    public function testGetMovesObject() : void
    {
        $exp = "App\Texas\PlayerMoves";

        $res = $this->player->getPlayerMoves();

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct betting amount.
     */
    public function testAddAndGetBets() : void
    {
        $this->player->addToBets(20);

        $exp = 20;

        $res = $this->player->getBets();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasPlayer sets and returns correct buy-in amount.
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
            'name' => "Martin",
            'role' => "",
            'buyIn' => 20,
            'hasFolded' => false,
            'bets' => 0,
            'holeCards' => [],
            'wallet' => 20,
            'move' => ''
        ];

        $res = $this->player->getPlayerData();

        $this->assertEquals($exp, $res);
    }
}