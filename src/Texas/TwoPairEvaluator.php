<?php

/**
 * This class is for evaluating if a hand has two pairs
 */

namespace App\Texas;

class TwoPairEvaluator implements EvaluatorInterface
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
}
