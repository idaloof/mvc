<?php

/**
 * Test suite for TexasDeck class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TexasDeckTest extends TestCase
{
    /**
     * @var TexasDeck $deck Deck to run tests for
     */

    private TexasDeck $deck;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->deck = new TexasDeck();
    }

    /**
     * Verify that the last card of the deck is King of Diamonds.
     */
    public function testGetDeckLastCard() : void
    {
        $exp = "King of diamonds";

        $deck = $this->deck->getDeck();
        $lastCard = $deck[array_key_last($deck)];

        $res = $lastCard->getCardName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasDeck is shuffled with seed and last card is three of spades.
     */
    public function testShuffleDeck() : void
    {
        $this->deck->shuffleDeck(3);

        $exp = "Three of spades";

        $deck = $this->deck->getDeck();
        $lastCard = $deck[array_key_last($deck)];

        $res = $lastCard->getCardName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasDeck drawSingle throws exception when no more cards to draw.
     */
    public function testDrawSingleException() : void
    {
        $this->deck->drawMany(52);

        $this->expectException(\Exception::class);

        $this->deck->drawSingle();
    }

    /**
     * Verify that TexasDeck drawSingle returns Ace of diamonds.
     */
    public function testDrawSingle() : void
    {
        $this->deck->shuffleDeck(3);

        $card = $this->deck->drawSingle();

        $exp = "Ace of diamonds";

        $res = $card->getCardName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasDeck drawMany returns array with two cards, ace of diamonds and eight of spades.
     */
    public function testDrawMany() : void
    {
        $this->deck->shuffleDeck(3);

        $cards = $this->deck->drawMany(2);

        $exp = "Ace of diamonds";

        $res = $cards[0]->getCardName();

        $this->assertEquals($exp, $res);

        $exp = "Eight of spades";

        $res = $cards[1]->getCardName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that TexasDeck deckCount returns 52.
     */
    public function testDeckCount() : void
    {
        $exp = 52;

        $res = $this->deck->getDeckCount();

        $this->assertEquals($exp, $res);
    }
}