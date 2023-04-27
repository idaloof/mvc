<?php

/**
 * Test class for ProbabilityTrait
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class ProbabilityTraitTest extends TestCase
{
    use ProbabilityTrait;

    /**
     * @var array<mixed, int> $cardIntValues Array of points for each card except ace.
     */
    private array $cardIntValues = [
        "A" => 1,
        "2" => 2,
        "3" => 3,
        "4" => 4,
        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "10" => 10,
        "J" => 10,
        "Q" => 10,
        "K" => 10
    ];

    /**
     * Test that probability for bust is zero percent when only two cards are drawn.
     */
    public function testProbabilityZero() : void
    {
        $deck = new Deck();
        $deck->shuffleDeck(3);
        $nrOfCards = 2;

        $points = 0;

        for($i = 1; $i <= $nrOfCards; $i++) {
            $aCard = $deck->drawSingle();
            $cardValue = $aCard["value"];
            $cardPoints = $this->cardIntValues[$cardValue];
            $points += $cardPoints;
        }

        $cardDeck = $deck->getDeck();

        $probability = $this->calculateProbability($cardDeck, $points);

        $this->assertEquals(0, $probability);
    }

    /**
     * Test that probability for bust is not zero,
     * when points is above 11.
     */
    public function testProbabilityNotZero() : void
    {
        $deck = new Deck();
        $deck->shuffleDeck(3); //Seed let's me know that the first three cards are A, 8 and 9.
        $nrOfCards = 3;

        $points = 0;

        for($i = 1; $i <= $nrOfCards; $i++) {
            $aCard = $deck->drawSingle();
            $cardValue = $aCard["value"];
            $cardPoints = $this->cardIntValues[$cardValue];
            $points += $cardPoints;
        }

        $cardDeck = $deck->getDeck();

        $probability = $this->calculateProbability($cardDeck, $points);

        $this->assertNotEquals(0, $probability);
    }
}