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
        $nrOfCards = $this->deck->getDeckCount();

        $this->assertEquals($expected, $nrOfCards);

        $expected = 50;
        $this->deck->drawSingle();
        $this->deck->drawSingle();
        $nrOfCards = $this->deck->getDeckCount();

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
    public function testShuffleDeckWithoutSeed() : void
    {
        $beforeShuffle = $this->deck->getDeckImages();

        $this->deck->shuffleDeck();

        $afterShuffle = $this->deck->getDeckImages();

        $this->assertNotEquals($beforeShuffle, $afterShuffle);
    }

    /**
     * Tests if shuffleDeck method with seed works correctly.
     */
    public function testShuffleDeckWithSeed() : void
    {
        $this->deck->shuffleDeck(234);

        $card = $this->deck->drawSingle();
        $cardImage = $card["image"];

        $this->assertEquals("KS", $cardImage);
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
