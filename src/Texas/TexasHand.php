<?php

/**
 * Class TexasHand
 * This class is responsible for keeping the player's hole cards.
 * It has dependencies towards the HandEvaluator class in order to decide the best hand
 * and the best hands points for comparison to other players.
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
