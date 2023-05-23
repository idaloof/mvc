<?php

/**
 * This class is for evaluating if a hand has a three of a kind
 */

namespace App\Texas;

class ThreeOfAKindEvaluator extends CalculatePoints implements EvaluatorInterface
{
    /**
     * Returns three of a kind if hand has it or empty string if not.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string                   "Three Of A Kind" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($ranks);
        $nrOfRanks = count($counts);

        foreach ($ranks as $rank) {
            if ($counts[$rank] === 3 && $nrOfRanks > 2) {
                return "Three Of A Kind";
            }
        }

        return "";
    }

    /**
     * Calculates and returns the points for a hand.
     *
     * @param array<string> $ranks  Ranks of the player's cards.
     *
     * @return int                  Number of points obtained from hand.
     */
    public function calculatePoints(array $ranks): int
    {
        $points = 0;
        $counts = array_count_values($ranks);
        $pairRank = array_search(3, $counts);

        $points += self::RANK_POINTS[$pairRank];
        $points += self::HAND_POINTS["Three Of A Kind"];

        return $points;
    }
}