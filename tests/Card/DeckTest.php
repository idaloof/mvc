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
}
