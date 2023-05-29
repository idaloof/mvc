<?php

/**
 * Test suite for Table class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    /**
     * @var Table $table Table object for testing.
     */
    private Table $table;

    /**
     * Set up before every test case.
     */
    protected function setUp(): void
    {
        $this->table = new Table(100);
    }

    /**
     * Verify that Table object correctly adds and gets community cards.
     */
    public function testAddAndGetCards(): void
    {
        $card = new Card("Ace of Hearts", "AH", "H", "A");

        $this->table->addToCommunityCards($card);

        $exp = "App\Texas\Card";

        $res = $this->table->getCommunityCards()[0];

        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Verify that Table object correctly clears community cards.
     */
    public function testClearCommunityCards(): void
    {
        $card = new Card("Ace of Hearts", "AH", "H", "A");

        $this->table->addToCommunityCards($card);

        $this->table->clearCommunityCards();

        $exp = 0;

        $res = count($this->table->getCommunityCards());

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that Table object correctly adds money to pot and gets correct amount.
     */
    public function testAddAndGetPot(): void
    {
        $this->table->addMoneyToPot(10);

        $exp = 10;

        $res = $this->table->getPot();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that Table object correctly adds money to pot and gets correct amount.
     */
    public function testClearAndGetPot(): void
    {
        $this->table->addMoneyToPot(10);

        $this->table->clearPot();

        $exp = 0;

        $res = $this->table->getPot();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Table sets and gets correct big blind.
     */
    public function testSetAndGetBigBlind() : void
    {
        $exp = 2;

        $res = $this->table->getBigBlind();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Table sets and gets correct small blind.
     */
    public function testSetAndGetSmallBlind() : void
    {
        $exp = 1;

        $res = $this->table->getSmallBlind();

        $this->assertEquals($exp, $res);
    }
}
