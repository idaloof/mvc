<?php

/**
 * This class is for evaluating if a hand has a straight
 */

namespace App\Texas;

class StraightEvaluator extends CalculatePoints implements EvaluatorInterface
{
    /**
     * Returns straight if hand has it or empty string if not.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string                   "Straight" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $specialArray = ["2", "3", "4", "5", "14"];
        sort($values);

        if ($values === $specialArray) {
            return "Straight";
        }

        for ($i = 0; $i < 4; $i++) {
            $currentValue = $values[$i];
            $nextValue = $values[$i + 1];

            if (!(intval($nextValue) === intval($currentValue) + 1)) {
                return "";
            }
        }

        return "Straight";
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
        sort($values);

        $specialArray = ["2", "3", "4", "5", "14"];
        if ($values === $specialArray) {
            $points += self::HAND_POINTS["Straight"];
            $points += 15;
            return $points;
        }

        $points += $sumValues;
        $points += self::HAND_POINTS["Straight"];

        return $points;
    }
}
