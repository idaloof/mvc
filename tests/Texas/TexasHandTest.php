<?php

/**
 * Test suite for TexasHand class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TexasHandTest extends TestCase
{
    /**
     * @var array<Card> $holeCards Hole card array to run tests for
     */
    private array $holeCards = [];

    /**
     * @var array<Card> $fullHand Full poker hand to run tests for
     */
    private array $fullHand = [];

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $cards = [
            new Card("A♠", "AS", "S", "A"),
            new Card("8♥", "8H", "H", "8"),
            new Card("9♦", "9D", "D", "9"),
            new Card("K♣", "KC", "C", "K"),
            new Card("T♥", "TH", "H", "T")
        ];

        for ($i = 0; $i < 2; $i++) {
            array_push($this->holeCards, $cards[$i]);
        }

        $this->fullHand = $cards;
    }

    /**
     * Verify that hole cards are set and gotten.
     */
    public function testHandSetAndGetHoleCards() : void
    {
        $hand = new TexasHand();

        $hand->setHoleCards($this->holeCards);

        $cards = $hand->getHoleCards();

        $exp = "A♠";

        $res = $cards[0]->getCardName();

        $this->assertEquals($exp, $res);

        $exp = 2;

        $res = count($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that best hand is set and gotten.
     */
    public function testHandSetAndGetBestHand() : void
    {
        $hand = new TexasHand();

        $hand->setBestHand($this->fullHand);

        $cards = $hand->getBestHand();

        $exp = '9♦';

        $res = $cards[2]->getCardName();

        $this->assertEquals($exp, $res);

        $exp = 5;

        $res = count($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that best hand is set and the
     * correct array of strings (card names) is returned.
     */
    public function testHandSetAndGetBestHandAsString() : void
    {
        $hand = new TexasHand();

        $hand->setBestHand($this->fullHand);

        $exp = ["A♠", "8♥", "9♦", "K♣", "T♥"];

        $res = $hand->getBestHandAsString();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that best hand name is set and gotten.
     */
    public function testHandSetAndGetHandName() : void
    {
        $hand = new TexasHand();

        $hand->setBestHandName("Straight");

        $res = $hand->getBestHandName();

        $exp = "Straight";

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that best hand points are set and gotten.
     */
    public function testHandSetAndGetHandPoints() : void
    {
        $hand = new TexasHand();

        $hand->setBestHandPoints(640);

        $res = $hand->getBestHandPoints();

        $exp = 640;

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that hole cards are folded.
     */
    public function testFoldHand() : void
    {
        $hand = new TexasHand();

        $hand->setHoleCards($this->holeCards);

        $hand->foldHand();

        $this->assertEmpty($hand->getHoleCards());
    }

    /**
     * Verify that the correct array of strings (card images) is returned.
     */
    public function testGetHoleImages() : void
    {
        $hand = new TexasHand();

        $hand->setHoleCards($this->holeCards);

        $exp = ["AS", "8H"];

        $res = $hand->getHoleCardsAsStrings();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that the correct array of strings (card images) is returned.
     */
    public function testBestHandImages() : void
    {
        $hand = new TexasHand();

        $hand->setBestHand($this->fullHand);

        $exp = ["AS", "8H", "9D", "KC", "TH"];

        $res = $hand->getBestHandAsImages();

        $this->assertEquals($exp, $res);
    }
}