<?php

/**
 * Test class for Deck class
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class DeckDrawTest extends TestCase
{
    /**
     * @var Deck $deck Deck of cards.
     */
    private Deck $deck;

    /**
     * Set up run before every test case
     */
    protected function setUp() : void
    {
        $this->deck = new Deck();
    }

    /**
     * Tests if drawOneCard method returns a single card array with certain keys.
     */
    public function testDrawOneCard() : void
    {
        $card = $this->deck->drawOneCard();
        $this->assertArrayHasKey("name", $card);
        $this->assertArrayHasKey("value", $card);
        $this->assertArrayHasKey("suit", $card);
        $this->assertArrayHasKey("image", $card);
    }

    /**
     * Tests if drawOneCard method returns correct array when empty.
     */
    public function testDrawOneCardEmptyDeck() : void
    {
        for($i = 0; $i <= 52; $i++) {
            $this->deck->drawOneCard();
        }

        $message = $this->deck->drawOneCard();
        $this->assertEquals(["No more cards to draw."], $message);
    }

    /**
     * Tests if drawSingle method returns the first card from the deck.
     */
    public function testDrawSingle() : void
    {
        $card = $this->deck->drawSingle();
        $this->assertArrayHasKey("name", $card);
        $this->assertArrayHasKey("value", $card);
        $this->assertArrayHasKey("suit", $card);
        $this->assertArrayHasKey("image", $card);
    }

    /**
     * Tests if drawSingle method returns correct array when empty.
     */
    public function testDrawSingleEmptyDeck() : void
    {
        for($i = 0; $i <= 52; $i++) {
            $this->deck->drawSingle();
        }

        $message = $this->deck->drawSingle();
        $this->assertEquals(["No more cards to draw."], $message);
    }

    /**
     * Tests if drawMany method returns correct amount of cards
     */
    public function testDrawMany() : void
    {
        $cards = $this->deck->drawMany(2);


        $expected = 2;
        $result = count($cards);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests if drawMany method throws exception when user tries to draw too many cards
     */
    public function testDrawManyException() : void
    {
        $this->expectException(\Exception::class);
        $this->deck->drawMany(53);
    }

    /**
     * Tests if drawManyCardsAndPlayers method returns correct amount of cards and players
     */
    public function testDrawManyCardsAndPlayers() : void
    {
        $allPlayersAndCards = $this->deck->drawManyCardsAndPlayers(2, 2);

        $result = count($allPlayersAndCards);

        $expected = 2;
        $this->assertEquals($expected, $result);

        $result = count($allPlayersAndCards[0]);

        $expected = 2;
        $this->assertEquals($expected, $result);
    }

    /**
     * Tests if drawManyCardsAndPlayers method throws exception when user tries to draw too many cards
     */
    public function testDrawManyCardsAndPlayersException() : void
    {
        $this->expectException(\Exception::class);
        $this->deck->drawManyCardsAndPlayers(5, 12);
    }
}
