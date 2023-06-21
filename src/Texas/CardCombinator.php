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
     * @param int $size Size of card hand (5 default).
     *
     * @return array<int, array<Card>>
     */
    private function findCombinations(array $cards, int $size = 5): array
    {
        if ($size == 1) {
            return array_map(function ($element) {
                return [$element];
            }, $cards);
        }

        $combinations = [];
        $count = count($cards);

        for ($i = 0; $i < $count; $i++) {
            $firstElement = $cards[$i];
            $remainingElements = array_slice($cards, $i + 1);
            $subCombinations = $this->findCombinations($remainingElements, $size - 1);

            foreach ($subCombinations as $subCombination) {
                $combinations[] = array_merge([$firstElement], $subCombination);
            }
        }

        return $combinations;
    }

    /**
     * Takes an array of cards and adds combinations to object property.
     *
     * @param array<Card> $cards All cards that can be combined.
     *
     * @return array<int, array<Card>>
     */
    public function setAndGetCombinations(array $cards): array
    {
        $this->combinations = $this->findCombinations($cards);

        return $this->combinations;
    }
}
