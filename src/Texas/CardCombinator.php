<?php

/**
 * CardCombinator class
 * This class provides the Game class with
 * a method that finds all the combinations of five card hands.
 */

namespace App\Texas;

class CardCombinator
{
    /**
     * @var array<int, array<Card>> $combinations All the combinations for chosen cards and number of
     */
    private array $combinations = [];

    /**
     * Takes an array of cards and a card hand size and adds combinations to object property.
     *
     * @param array<Card> $cards All cards that can be combined.
     * @param int $size Size of card hand.
     *
     * @return array<int, array<Card>>
     */
    public function findAndAddCombinations(array $cards, int $size): array
    {
        if ($size == 1) {
            return array_map(function ($element) {
                return [$element];
            }, $cards);
        }

        $count = count($cards);

        for ($i = 0; $i < $count; $i++) {
            $firstElement = $cards[$i];
            $remainingElements = array_slice($cards, $i + 1);
            $subCombinations = $this->findAndAddCombinations($remainingElements, $size - 1);

            foreach ($subCombinations as $subCombination) {
                $this->combinations[] = array_merge([$firstElement], $subCombination);
            }
        }

        return $this->combinations;
    }
}
