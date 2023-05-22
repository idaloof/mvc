<?php

/**
 * HandEvaluator class
 * This class has a method that iterates over an array with evaluation classes
 * through which a player's hand is evaluated.
 */

namespace App\Texas;

class HandEvaluator
{
    /**
     * @var array<EvaluatorInterface> $evaluators
     */
    private array $evaluators;

    /**
     * Class constructor
     *
     * @param array<EvaluatorInterface> $evaluators     Array of evaluator classes
     *
     */
    public function __construct(array $evaluators)
    {
        $this->evaluators = $evaluators;
    }

    /**
     * Returns the current poker hand of a player based on the player's cards.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return string           The kind of hand the player has.
     *
     */

    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        foreach ($this->evaluators as $evaluator) {
            if ($evaluator->evaluateHand($suits, $values, $ranks)) {
                return $evaluator->evaluateHand($suits, $values, $ranks);
            }
        }

        return "High Card";
    }
}
