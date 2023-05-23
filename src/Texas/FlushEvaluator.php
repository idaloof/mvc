<?php

/**
 * This class is for evaluating if a hand has a flush
 */

namespace App\Texas;

class FlushEvaluator extends CalculatePoints implements EvaluatorInterface
{
    /**
     * Returns flush if hand has it or empty string if not.
     *
     * @param array<string>     $suits      Suits of the player's cards.
     * @param array<string>     $values     Values of the player's cards.
     * @param array<string>     $ranks      Ranks of the player's cards.
     *
     * @return string                   "Flush" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($suits);

        return ($counts[$suits[0]] === 5) ? "Flush" : "";
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
        $sumValues = array_sum($values);

        $points += $sumValues;
        $points += self::HAND_POINTS["Flush"];

        return $points;
    }
}
