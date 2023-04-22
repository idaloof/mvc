<?php

/**
 * Class Hand
 */

namespace App\Card;

class Hand
{
    /**
     * @var array<string, array<string, string>> $cards     Cards in hand.
     */
    private array $cards = [];

    /**
     * Adds card to hand.
     *
     * @param array<string> $card Array with information about card.
     *
     * @return void
     */
    public function addCard(array $card): void
    {
        array_push($this->cards, $card);
    }

    /**
     * Checks if hand has ace.
     *
     * @return bool whether hand has ace or not.
     */
    public function hasAce(): bool
    {
        foreach ($this->cards as $card) {
            if ($card["value"] === "A") {
                return true;
            }
        }

        return false;
    }

    /**
     * Get card values.
     *
     * @return array<string> with card values.
     */
    public function getCardValues(): array
    {
        $cardValues = [];

        foreach ($this->cards as $card) {
            array_push($cardValues, $card["value"]);
        }

        return $cardValues;
    }

    /**
     * Get card images.
     *
     * @return array<string> with card images.
     */
    public function getCardImages(): array
    {
        $cardImages = [];

        foreach ($this->cards as $card) {
            array_push($cardImages, $card["image"]);
        }

        return $cardImages;
    }
}
