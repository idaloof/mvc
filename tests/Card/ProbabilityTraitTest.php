<?php

/**
 * Test class for ProbabilityTrait
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class ProbabilityTraitTest extends TestCase
{
    /**
     * @var array $standings Array with current game standings
     */
    private array $standings;

    /**
     * @var Deck $deck Deck of cards
     */
    private Deck $deck;

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
     * Test that probability for bust is zero percent
     */
    public function testProbabilityZero()
    {
        $this->deck = $this->createMock(Deck::class);
        $nrOfCards = 2;

        $this->standings = [
            "human" => [
                "points" => 0
            ]
        ];

        for($i = 1; $i <= $nrOfCards; $i++) {
            $aCard = $this->deck->drawSingle();
            $cardValue = $aCard["value"];
            $cardPoints = $this->cardIntValues[$cardValue];
            $this->standings["human"]["points"] += $cardPoints;
        }
    }
}