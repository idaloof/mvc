<?php

/**
 * This class is for calculation points for a hand with only high card.
 */

namespace App\Texas;

class HighCardEvaluator extends CalculatePoints implements EvaluatorInterface
{
    /**
     * Returns high card if hand has it or empty string if not.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string                   "High Card".
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        return "High Card";
    }

    /**
     * Calculates and returns the points for a hand.
     *
     * @param array<string> $values Values of the player's cards.
     *
     * @return int                  Number of points obtained from hand.
     */
    public function calculatePoints(array $values): int
    {
        $points = 0;
        $sumValues = intval(array_sum($values));

        $points += $sumValues;
        $points += self::HAND_POINTS["High Card"];

        return $points;
    }
}
