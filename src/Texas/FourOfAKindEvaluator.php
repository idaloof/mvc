<?php

/**
 * This class is for evaluating if a hand has a four of a kind
 */

namespace App\Texas;

class FourOfAKindEvaluator implements EvaluatorInterface
{
    /**
     * Returns four of a kind if hand has it or empty string if not.
     *
     * @param array<string>  $suits      Suits of the player's cards.
     * @param array<string>  $values     Values of the player's cards.
     * @param array<string>  $ranks      Ranks of the player's cards.
     *
     * @return string                   "Four Of A Kind" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($ranks);

        foreach ($ranks as $rank) {
            if ($counts[$rank] === 4) {
                return "Four Of A Kind";
            }
        }

        return "";
    }
}
