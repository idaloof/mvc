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
            new Card("Ace of spades", "AS", "S", "A"),
            new Card("Eight of hearts", "8H", "H", "8"),
            new Card("Nine of diamonds", "9D", "D", "9"),
            new Card("King of clubs", "KC", "C", "K"),
            new Card("Ten of hearts", "10H", "H", "10")
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

        $exp = "Ace of spades";

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

        $exp = "Nine of diamonds";

        $res = $cards[2]->getCardName();

        $this->assertEquals($exp, $res);

        $exp = 5;

        $res = count($cards);

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
}