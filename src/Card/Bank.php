<?php

/**
 * Class Bank
 */

namespace App\Card;

class Bank extends Player
{
    /**
     * Class constructor
     *
     * @param Hand      $hand   Hand with cards
     * @param Points    $points Points class with player points.
     *
     */
    public function __construct(Hand $hand, Points $points)
    {
        parent::__construct($hand, $points);
    }

    /**
     * Checks if bank is over 17 points.
     *
     * @return bool whether bank is over 17 or not.
     */
    public function checkOverSeventeen(): bool
    {
        $rules = new Rules();

        return $rules->overSeventeen($this->getPlayerDefinitivePoints());
    }
}
