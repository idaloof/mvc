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
     * @return float                  Number of points obtained from hand.
     */
    public function calculatePoints(array $values): float
    {
        $points = 0;
        sort($values);

        $specialArray = ["2", "3", "4", "5", "14"];
        if ($values === $specialArray) {
            $points += self::HAND_POINTS["Straight"];
            $points += $this->calculateKickerPoints(["2", "3", "4", "5", "1"]);
            return $points;
        }

        $points += $this->calculateKickerPoints($values);
        $points += self::HAND_POINTS["Straight"];

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
            $kicker = intval($kicker);
            $points += ($kicker**8) / 10**6;
        }

        return $points;
    }
}
