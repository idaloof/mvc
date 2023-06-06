<?php

/**
 * HandEvaluator class
 * This class has a method that iterates over an array with evaluation classes
 * through which a player's hand is evaluated.
 */

namespace App\Texas;

class HandEvaluator extends CardCombinator
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
     * manually instantiate and inject evaluators. (see service.yaml file)
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
     * Returns the current poker hand of a player and its points based on the player's cards.
     *
     * @param array<string> $suits      Suits of the player's cards.
     * @param array<string> $values     Values of the player's cards.
     * @param array<string> $ranks      Ranks of the player's cards.
     *
     * @return array<mixed>             The kind of hand the player has and the points for the hand.
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

    /**
     * Takes an array of card objects and returns the card suits as an array of strings.
     *
     * @param array<Card> $cards
     *
     * @return array<string> Card suits.
     */
    public function cardSuitsToString(array $cards): array
    {
        $suits = [];

        foreach ($cards as $card) {
            array_push($suits, $card->getCardSuit());
        }

        return $suits;
    }

    /**
     * Takes an array of card objects and returns the card values as an array of strings.
     *
     * @param array<Card> $cards
     *
     * @return array<string> Card values.
     */
    public function cardValuesToString(array $cards): array
    {
        $values = [];

        foreach ($cards as $card) {
            array_push($values, $card->getCardValue());
        }

        return $values;
    }

    /**
     * Takes an array of card objects and returns the card ranks as an array of strings.
     *
     * @param array<Card> $cards
     *
     * @return array<string> Card ranks.
     */
    public function cardRanksToString(array $cards): array
    {
        $ranks = [];

        foreach ($cards as $card) {
            array_push($ranks, $card->getCardRank());
        }

        return $ranks;
    }

    /**
     * Returns an array of all hand combinations with their names and points.
     *
     * @param array<int, array<Card>> $hands    All possible current hands that the player can use.
     *
     * @return array<int, array<mixed>>         The kind of hand the player has.
     *
     */
    public function evaluateManyHands(array $hands): array
    {
        $handData = [];

        foreach ($hands as $hand) {
            $suits = $this->cardSuitsToString($hand);
            $values = $this->cardValuesToString($hand);
            $ranks = $this->cardRanksToString($hand);

            foreach ($this->evaluators as $evaluator) {
                if ($evaluator->evaluateHand($suits, $values, $ranks)) {
                    $handName = $evaluator->evaluateHand($suits, $values, $ranks);
                    $handPoints = $evaluator->calculatePoints($values);
                    $handData[] = [$handPoints, $handName, $hand];
                }
            }
        }

        $this->sortHandData($handData);

        return $handData;
    }

    /**
     * Compares the points of the hands from evaluation method.
     *
     * @param array<mixed> $first
     * @param array<mixed> $next
     *
     * @return int
     */
    public function compareFirstElement($first, $next): int
    {
        return $first[0] <=> $next[0];
    }

    /**
     * Sorts the different hand combinations the player can have by points.
     *
     * @param array<mixed> $handData Current hand combinations.
     *
     * @return void
     */
    public function sortHandData(array $handData): void
    {
        usort($handData, array($this, 'compareFirstElement'));
    }

}
