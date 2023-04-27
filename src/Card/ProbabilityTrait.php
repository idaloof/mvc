<?php

/**
 * Probability Trait
 * Calculates probability for going bust,
 * which depends on player current points and the cards left in deck.
 */

namespace App\Card;

trait ProbabilityTrait
{
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
     * Calculates probability for going bust and returns probability
     *
     * @param array<string,array<string,string>>    $deck       Current deck.
     * @param int                                   $points     Player points
     *
     * @return float probability value
     */
    public function calculateProbability($deck, array $standings): float
    {
        $playerPoints = $standings["human"]["points"];
        $neededForBust = 22 - $playerPoints;

        $nrOfCardsInDeck = count($deck);

        $bustCards = 0;

        foreach ($deck as $card) {
            $cardValue = $card["value"];
            $cardPoint = $this->cardIntValues[$cardValue];

            if ($cardPoint >= $neededForBust) {
                $bustCards++;
            }
        }

        if ($bustCards === 0) {
            return 0.0;
        }

        $probability = round($bustCards/$nrOfCardsInDeck, 3) * 100;
        return $probability;
    }
}
