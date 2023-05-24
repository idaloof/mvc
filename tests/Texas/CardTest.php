<?php

/**
 * Test suite for Card class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class CardTest extends TestCase
{
    /**
     * @var Card $card Card to run tests for
     */

    private Card $card;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->card = new Card("Ace of spades", "AS", "S", "A");
    }

    /**
     * Verify that Card returns correct name.
     */
    public function testCardReturnName() : void
    {
        $exp = "Ace of spades";

        $res = $this->card->getCardName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Card returns correct image name.
     */
    public function testCardReturnImage() : void
    {
        $exp = "AS";

        $res = $this->card->getCardImage();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Card returns correct suit.
     */
    public function testCardReturnSuit() : void
    {
        $exp = "S";

        $res = $this->card->getCardSuit();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Card returns correct value.
     */
    public function testCardReturnValue() : void
    {
        $exp = 14;

        $res = $this->card->getCardValue();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Card returns correct rank.
     */
    public function testCardReturnRank() : void
    {
        $exp = "A";

        $res = $this->card->getCardRank();

        $this->assertEquals($exp, $res);
    }
}