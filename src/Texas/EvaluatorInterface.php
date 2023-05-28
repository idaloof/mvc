<?php

/**
 * This interface sets the methods of every evaluator class.
 */

namespace App\Texas;

interface EvaluatorInterface
{
    /**
     * Evaluates a hand and returns name of hand (string)
     *
     * @param array<string> $suits      Suits of player's cards in hand.
     * @param array<string> $values     Values of player's cards in hand.
     * @param array<string> $ranks      Ranks of player's cards in hand.
     *
     * @return string
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string;

    /**
     * Calculates points for hand.
     *
     * @param array<string> $values      Values of player's 5 card combination.
     *
     * @return int
     */
    public function calculatePoints(array $values): int;
}
