<?php

/**
 * Class Points
 */

namespace App\Card;
use App\Card\Rules;

class Points
{
    /**
     * @var array $cardIntValues
     * @var array $handPoints
     * @var int $bestHandPoints
     */
    
    private array $cardIntValues = [
        "2" => 2,
        "3" => 3,
        "4" => 4,
        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "10" => 10,
        "J" => 10,
        "Q" => 10,
        "K" => 10
    ];

    private array $handPoints = [
        "high" => 0,
        "low" => 0
    ];

    private int $bestHandPoints = 0;

    /**
     * Calculates points for player.
     *
     * @param Hand $hand Player hand.
     *
     * @return void
     */
    public function calculatePoints(Hand $hand) : void {
        $cards = $hand->getCardValues();
        $points = 0;
        $numberOfAces = 0;

        for ($i = 0; $i < count($cards); $i++) {
            $points +=
                ($cards[$i]["value"] === "A") ? ++$numberOfAces :
                $this->cardIntValues[$cards[$i]["value"]];
        }

        $this->handPoints["low"] = $points;
        $this->handPoints["high"] = $points;

        if ($numberOfAces > 0) {
            $this->calculateAcePointsAndAssign($points, $numberOfAces);
        }
    }

    /**
     * Calculates points for aces and assigns high and low values to instance property (array).
     *
     * @param int $points   Total points without aces.
     * @param int $aces     Number of aces
     *
     * @return void
     */
    public function calculateAcePointsAndAssign(int $points, int $aces) : void {
        $current_points = $points;
        $pointsForAcesLow = $aces;
        $pointsForAcesHigh = 0;

        if ($current_points <= (11 - $aces)) {
            $pointsForAcesHigh += (10 + $aces);
        } elseif ($current_points > (11 - $aces)) {
            $pointsForAcesHigh += $aces;
        }

        $this->handPoints["low"] += $pointsForAcesLow;
        $this->handPoints["high"] += $pointsForAcesHigh;
    }

    /**
     * Decides which points is the best and assigns best points.
     *
     * @return void
     */
    public function setBestHandPoints() : void {
        $this->bestHandPoints = ($this->handPoints["high"] < 21) ?
            $this->handPoints["high"] :
            $this->handPoints["low"];
    }

    /**
     * Gets best hand points.
     *
     * @return int with hand's best points.
     */
    public function getBestHandPoints() : int {
        return $this->bestHandPoints;
    }

    /**
     * Checks if high and low are the same.
     *
     * @return bool whether high and low are same.
     */
    public function highEqualToLow() : bool {
        if ($this->handPoints["high"] === $this->handPoints["low"]) {
            return true;
        }

        return false;
    }

    /**
     * Returns array or int with points depending on bust or not.
     *
     * @return int|array with
     */
    public function getPoints() : int|array {
        $highEqualsLow = $this->highEqualToLow();
        $rules = new Rules();

        if ($rules->bust($this->handPoints["high"]) or $highEqualsLow) {
            return $this->handPoints["low"];
        }

        return $this->handPoints;
    }
}