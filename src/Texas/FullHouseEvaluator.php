<?php

/**
 * This class is for evaluating if a hand has a full house
 */

namespace App\Texas;

class FullHouseEvaluator implements EvaluatorInterface
{
    /**
     * Returns full house if hand has it or empty string if not.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string                   "Full House" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($ranks);
        $countsValues = array_values($counts);

        if (count($counts) === 2 && in_array(2, $countsValues) && in_array(3, $countsValues)) {
            return "Full House";
        }

        return "";
    }
}
