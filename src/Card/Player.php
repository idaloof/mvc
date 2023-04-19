<?php

/**
 * Class Player
 */

namespace App\Card;

class Player
{
    /**
     * @var Hand    $hand       Hand with cards
     * @var bool    $stop       Boolean whether player has stopped or not
     * @var string  $name       Name of player
     * @var Points  $points     Points class
     */
    protected Hand $hand;
    protected bool $stop;
    protected string $name;
    protected Points $points;

    /**
     * Class constructor
     *
     * @param string    $name   Name of player
     * @param Hand      $hand   Hand with cards
     * @param Points    $points Points class with player points.
     *
     */
    public function __construct(string $name, Hand $hand, Points $points)
    {
        $this->name = $name;
        $this->hand = $hand;
        $this->points = $points;
        $this->stop = false;
    }

    /**
     * Sets property stop to true
     *
     * @return void
     */
    public function setStop() : void {
        $this->stop = true;
    }

    /**
     * Gets bool value of property stop.
     *
     * @return bool player has stopped or not.
     */
    public function getStop() : bool {
        return $this->stop;
    }

    /**
     * Calculates player's points.
     *
     * @return void
     */
    public function calculatePlayerPoints() : void {
        $this->points->calculatePoints($this->hand);
    }

    /**
     * Sets player's best points for hand of cards.
     *
     * @return void
     */
    public function setPlayerDefinitivePoints() : void {
        $this->points->setBestHandPoints();
    }

    /**
     * Gets player's best points for hand of cards.
     *
     * @return int with best points possible.
     */
    public function getPlayerDefinitivePoints() : int {
        return $this->points->getBestHandPoints();
    }

    /**
     * Sets player's best points for hand of cards.
     *
     * @return int|array with player's points.
     */
    public function getPlayerPoints() : int|array {
        return $this->points->getPoints();
    }

    /**
     * Adds card to player hand.
     *
     * @return void
     */
    public function addCardToPlayerHand($card) : void {
        $this->hand->addCard($card);
    }

    /**
     * Get player card images.
     *
     * @return array with player card images.
     */
    public function getPlayerCardImages() : array {
        return $this->hand->getCardImages();
    }
}