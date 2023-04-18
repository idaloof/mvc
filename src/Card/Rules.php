<?php

/**
 * Class Rules
 */

namespace App\Card;

use App\Card\Points;

class Rules
{
    /**
     * Returns bool if player is bust.
     *
     * @param int $points 
     *
     * @return bool of images.
     */
    public function bust(int $points) : bool {
        if ($points > 21) {
            return true;
        }

        return false;
    }

    /**
     * Returns bool if player (bank) has reached more than 17 points
     *
     * @param int $points 
     *
     * @return bool of images.
     */
    public function overSeventeen(int $points) : bool {
        if ($points > 17) {
            return true;
        }

        return false;
    }

    /**
     * Compares points between human and bank and returns winner
     *
     * @param int $pointsHuman 
     * @param int $pointsBank 
     *
     * @return string with winner
     */
    public function decideWinner(int $pointsHuman, int $pointsBank) {
        if ($pointsHuman > $pointsBank) {
            return "human";
        }

        return "bank";
    }
}