<?php

/**
 * This class is for evaluating if a hand has a flush
 */

namespace App\Texas;

class FlushEvaluator implements EvaluatorInterface
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
}
