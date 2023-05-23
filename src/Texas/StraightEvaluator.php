<?php

/**
 * This class is for evaluating if a hand has a straight
 */

namespace App\Texas;

class StraightEvaluator implements EvaluatorInterface
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
        $count = 0;

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
}
