<?php

/**
 * Class TexasHand
 * This class is responsible for keeping the player's hole cards,
 * and best hand cards, name and points.
 */

namespace App\Texas;

class TexasHand
{
    /**
     * @var array<Card>     $holeCards          Cards in hand.
     */
    private array $holeCards = [];

    /**
     * @var array<Card>     $bestHand           Best possible five card hand.
     */
    private array $bestHand = [];

    /**
     * @var string          $bestHandName       Name of best hand.
     */
    private string $bestHandName = "";

    /**
     * @var int             $bestHandPoints     Points of best hand.
     */
    private int $bestHandPoints = 0;

    /**
     * Gets player's hole cards.
     *
     * @return array<Card> Player's hole cards.
     */
    public function getHoleCards(): array
    {
        return $this->holeCards;
    }

    /**
     * Gets player's hole cards as array with strings.
     *
     * @return array<string> Player's hole cards as array with strings.
     */
    public function getHoleCardsAsStrings(): array
    {
        $cardStrings = [];

        foreach ($this->holeCards as $card) {
            array_push($cardStrings, $card->getCardImage());
        }

        return $cardStrings;
    }

    /**
     * Sets player's hole cards.
     *
     * @param array<Card> $cards Array with two hole cards.
     *
     * @return void
     */
    public function setHoleCards(array $cards): void
    {
        $this->holeCards = $cards;
    }

    /**
     * Folds player's hand.
     *
     * @return void
     */
    public function foldHand(): void
    {
        $this->holeCards = [];
    }

    /**
     * Gets player's best hand.
     *
     * @return array<Card> Player's best hand.
     */
    public function getBestHand(): array
    {
        return $this->bestHand;
    }

    /**
     * Gets player's best hand as array with strings.
     *
     * @return array<string> Player's best hand as array with strings.
     */
    public function getBestHandAsString(): array
    {
        $handString = [];

        foreach ($this->bestHand as $card) {
            array_push($handString, $card->getCardName());
        }

        return $handString;
    }

    /**
     * Gets player's best hand as array with image names.
     *
     * @return array<string> Player's best hand as array with image names.
     */
    public function getBestHandAsImages(): array
    {
        $handImages = [];

        foreach ($this->bestHand as $card) {
            array_push($handString, $card->getCardImage());
        }

        return $handImages;
    }

    /**
     * Sets player's best hand.
     *
     * @param array<Card> $cards Array with best five card combination.
     *
     * @return void
     */
    public function setBestHand(array $cards): void
    {
        $this->bestHand = $cards;
    }

    /**
     * Gets name of best hand.
     *
     * @return string Name of hand.
     */
    public function getBestHandName(): string
    {
        return $this->bestHandName;
    }

    /**
     * Sets name of best hand.
     *
     * @param string $handName Name of hand.
     *
     * @return void
     */
    public function setBestHandName(string $handName): void
    {
        $this->bestHandName = $handName;
    }

    /**
     * Gets points for best hand.
     *
     * @return int Points for hand.
     */
    public function getBestHandPoints(): int
    {
        return $this->bestHandPoints;
    }

    /**
     * Sets points for best hand.
     *
     * @param int $handPoints Points for hand.
     *
     * @return void
     */
    public function setBestHandPoints(int $handPoints): void
    {
        $this->bestHandPoints = $handPoints;
    }
}
