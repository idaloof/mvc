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
     * @return string                   "High Card" or empty.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $nrOfCards = count($values);
        sort($values);
        $count = 0;

        for ($i = 0; $i < $nrOfCards - 1; $i++) {
            if ($values[$i] === $values[$i + 1]) {
                $count++;
            }
        }

        // At this point, $count represents the number of pairs found in the hand.
        // If $count is 0, it means there are no pairs, so "High Card" is returned.
        return ($count === 0) ? "High Card" : "";
    }

    /**
     * Calculates and returns the points for a hand.
     *
     * @param array<string> $values Values of the player's cards.
     *
     * @return float                  Number of points obtained from hand.
     */
    public function calculatePoints($values): float
    {
        $points = 0;

        $points += self::HAND_POINTS["High Card"];
        $points += $this->calculateKickerPoints($values);

        $points = sprintf("%.3f", $points);
        $points = floatval($points);

        return $points;
    }

    /**
     * Calculates points for all kickers.
     *
     * @param array<string> $kickers
     *
     * @return float Points for all kickers.
     */
    public function calculateKickerPoints(array $kickers): float
    {
        $points = 0;

        foreach ($kickers as $kicker) {
            $points += ($kicker**8) / 10**6;
        }

        return $points;
    }
}
