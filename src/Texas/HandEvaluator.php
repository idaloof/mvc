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
     * Creates a HandEvaluator object without the need to
     * manually instantiate and inject evaluators.
     *
     * @param \traversable<EvaluatorInterface> $evaluators
     *
     * @return self This object.
     */
    public static function create(iterable $evaluators): self
    {
        $evaluatorArray = iterator_to_array($evaluators);
        return new self($evaluatorArray);
    }

    /**
     * Returns the current poker hand of a player based on the player's cards.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return array<mixed>           The kind of hand the player has.
     *
     */

    public function evaluateHand(array $suits, array $values, array $ranks): array
    {
        $handData = [];

        foreach ($this->evaluators as $evaluator) {
            if ($evaluator->evaluateHand($suits, $values, $ranks)) {
                $handData[] = $evaluator->evaluateHand($suits, $values, $ranks);
                $handData[] = $evaluator->calculatePoints($values);
            }
        }

        return $handData;
    }
}
