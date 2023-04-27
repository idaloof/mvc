<?php

/**
 * Class Player
 */

namespace App\Card;

class Player
{
    /**
     * @var Hand    $hand       Hand with cards.
     * @var string  $name       Player name.
     * @var Points  $points     Points class.
     */
    protected Hand $hand;
    protected string $name;
    protected Points $points;

    /**
     * Class constructor
     *
     * @param Hand      $hand   Hand with cards
     * @param Points    $points Points class with player points.
     *
     */
    public function __construct(Hand $hand, Points $points)
    {
        $this->name = "human";
        $this->hand = $hand;
        $this->points = $points;
    }

    /**
     * Gets name of player.
     *
     * @return string name of player.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets name of player.
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Calculates player's points.
     *
     * @return void
     */
    public function calculatePlayerPoints(): void
    {
        $this->points->calculatePoints($this->hand);
    }

    /**
     * Sets player's best points for hand of cards.
     *
     * @return void
     */
    public function setPlayerDefinitivePoints(): void
    {
        $this->points->setBestHandPoints();
    }

    /**
     * Gets player's best points for hand of cards.
     *
     * @return int with best points possible.
     */
    public function getPlayerDefinitivePoints(): int
    {
        return $this->points->getBestHandPoints();
    }

    /**
     * Sets player's best points for hand of cards.
     *
     * @return int|array<string,int> with player's points.
     */
    public function getPlayerPoints(): int|array
    {
        return $this->points->getPoints();
    }

    /**
     * Adds card to player hand.
     *
     * @param array<mixed,string> $card Card to be added to hand.
     *
     * @return void
     */
    public function addCardToPlayerHand($card): void
    {
        $this->hand->addCard($card);
    }

    /**
     * Get player card images.
     *
     * @return array<string> with player card images.
     */
    public function getPlayerCardImages(): array
    {
        return $this->hand->getCardImages();
    }

    /**
     * Get player card values.
     *
     * @return array<string> with player card images.
     */
    public function getPlayerCardValues(): array
    {
        return $this->hand->getCardValues();
    }

    /**
     * Get player's low points.
     *
     * @return int with low points.
     */
    public function getPlayerLowPoints(): int
    {
        return $this->points->getLowPoints();
    }

    /**
     * Get player's high points.
     *
     * @return int with high points.
     */
    public function getPlayerHighPoints(): int
    {
        return $this->points->getHighPoints();
    }
}
