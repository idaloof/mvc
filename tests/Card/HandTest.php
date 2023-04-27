<?php

/**
 * Test class for Hand class
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class HandTest extends TestCase
{
    /**
     * @var Hand $hand Hand with cards.
     */
    private Hand $hand;

    /**
     * Set up run before every test case
     */
    protected function setUp() : void
    {
        $this->hand = new Hand();
    }

    /**
     * Verify that hand contains certain cards
     */
    public function testAddCardCheckValues() : void
    {
        $deck = new Deck();
        $deck->shuffleDeck(3);

        for($i = 0; $i < 2; $i++){
            $card = $deck->drawSingle();

            $this->hand->addCard($card);
        }

        $exp = ["A", "8"];
        $res = $this->hand->getCardValues();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that cards in hand have certain image strings.
     */
    public function testAddCardCheckImages() : void
    {
        $deck = new Deck();
        $deck->shuffleDeck(3);

        for($i = 0; $i < 2; $i++){
            $card = $deck->drawSingle();

            $this->hand->addCard($card);
        }

        $exp = ["AD", "8S"];
        $res = $this->hand->getCardImages();

        $this->assertEquals($exp, $res);
    }
}