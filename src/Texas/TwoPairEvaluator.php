<?php

/**
 * This class is for evaluating if a hand has two pairs
 */

namespace App\Texas;

class TwoPairEvaluator extends CalculatePoints implements EvaluatorInterface
{
    /**
     * Returns two pair if hand has it or empty string if not.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string                   "Two Pair" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($ranks);
        $pairs = [];

        for ($i = 0; $i < 5; $i++) {
            $card = $ranks[$i];

            if ($counts[$card] === 2 && !in_array($card, $pairs)) {
                array_push($pairs, $card);
            }
        }

        return (count($pairs) === 2) ? "Two Pair" : "";
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
        $uniqueCards = array_keys($counts);

        $pairRank = [];

        for ($i = 0; $i < 3; $i++) {
            if ($counts[$uniqueCards[$i]] === 2) {
                array_push($pairRank, self::RANK_POINTS[$uniqueCards[$i]]);
            }
        }

        $points += max($pairRank);
        $points += self::HAND_POINTS["Two Pair"];

        return $points;
    }
}
