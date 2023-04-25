<?php

/**
 * Test class for Deck class
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class DeckTest extends TestCase
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
     * Tests if a new instance of class Deck is created with keyword "new"
     * and verifies that deck property contains 52 arrays with card info.
     */
    public function testCreateDeckObject() : void
    {
        $this->assertInstanceOf("App\Card\Deck", $this->deck);
    }

    /**
     * Tests if getDeck method returns array of 52 items.
     */
    public function testGetDeckCount() : void
    {
        $expected = 52;
        $nrOfCards = count($this->deck->getDeck());

        $this->assertEquals($expected, $nrOfCards);
    }

    /**
     * Tests if getDeckImages method returns array with correct images.
     */
    public function testGetImagesContains() : void
    {
        $expected = [];
        foreach($this->deck->getDeck() as $card) {
            array_push($expected, $card['image']);
        }

        $result = $this->deck->getDeckImages();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests if shuffleDeck method rearranges cards in deck.
     */
    public function testShuffleDeck() : void
    {
        $beforeShuffle = $this->deck->getDeckImages();

        $this->deck->shuffleDeck();

        $afterShuffle = $this->deck->getDeckImages();

        $this->assertNotEquals($beforeShuffle, $afterShuffle);
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
}

