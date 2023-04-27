<?php

/**
 * Test class for Bank class
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class BankTest extends TestCase
{
    /**
     * @var Bank $bank Class representing the bank player.
     */
    private bank $bank;

    /**
     * Set up run before every test case
     */
    protected function setUp() : void
    {
        $hand = new Hand();
        $points = new Points();
        $this->bank = new Bank($hand, $points);
    }

    /**
     * Verify that a bank object is instantiated.
     */
    public function testCreateBankObject()
    {
        $hand = new Hand();
        $points = new Points();
        $bank = new Bank($hand, $points);

        $this->assertInstanceOf("App\Card\Bank", $bank);
    }

    /**
     * Verify that overSeventeen method returns bool.
     */
    public function testBankOverSeventeenBool()
    {
        $deck = new Deck();
        $deck->shuffleDeck(3);

        $card = $deck->drawSingle();

        $this->bank->addCardToPlayerHand($card);

        $res = $this->bank->checkOverSeventeen();
        $this->assertIsBool($res);
    }
}