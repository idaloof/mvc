<?php

/**
 * This class is for evaluating if a hand has one pair
 */

namespace App\Texas;

class OnePairEvaluator implements EvaluatorInterface
{
    /**
     * Returns one pair if hand has it or empty string if not.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string                   "One Pair" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($ranks);

        if (count($counts) === 4) {
            return "One Pair";
        }

        return "";
    }
}
