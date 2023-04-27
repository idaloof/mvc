<?php

/**
 * Class Points
 */

namespace App\Card;

use App\Card\Rules;

class Points
{
    /**
     * @var array<mixed, int> $cardIntValues Array of points for each card except ace.
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

    /**
     * @var array<string,int> $handPoints Array of high and low points.
     */
    private array $handPoints = [
        "low" => 0,
        "high" => 0
    ];

    /**
     * @var int $bestHandPoints The best possible points for a certain hand of cards.
     */
    private int $bestHandPoints = 0;

    /**
     * Calculates points for player.
     *
     * @param Hand $hand Player hand.
     *
     * @return void
     */
    public function calculatePoints(Hand $hand): void
    {
        $cards = $hand->getCardValues();
        $points = 0;
        $numberOfAces = 0;
        $nrOfCards = count($cards);

        for ($i = 0; $i < $nrOfCards; $i++) {
            $numberOfAces += ($cards[$i] === "A") ? 1 : 0 ;

            if ($cards[$i] !== "A") {
                $points += $this->cardIntValues[$cards[$i]];
            }
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
    public function calculateAcePointsAndAssign(int $points, int $aces): void
    {
        $currentPoints = $points;
        $pointsForAcesLow = $aces;
        $pointsForAcesHigh = 0;

        if ($currentPoints <= (11 - $aces)) {
            $pointsForAcesHigh += (10 + $aces);
        } elseif ($currentPoints > (11 - $aces)) {
            $pointsForAcesHigh += 1 * $aces;
        }

        $this->handPoints["low"] += $pointsForAcesLow;
        $this->handPoints["high"] += $pointsForAcesHigh;
    }

    /**
     * Decides which points is the best and assigns best points.
     *
     * @return void
     */
    public function setBestHandPoints(): void
    {
        $this->bestHandPoints =
            ($this->handPoints["high"] <= 21) ?
            $this->handPoints["high"] :
            $this->handPoints["low"];
    }

    /**
     * Gets best hand points.
     *
     * @return int with hand's best points.
     */
    public function getBestHandPoints(): int
    {
        return $this->bestHandPoints;
    }

    /**
     * Checks if high and low are the same.
     *
     * @return bool whether high and low are same.
     */
    public function highEqualToLow(): bool
    {
        if ($this->handPoints["high"] === $this->handPoints["low"]) {
            return true;
        }

        return false;
    }

    /**
     * Returns array or int with points depending on bust or not.
     *
     * @return array<string, int>|int with player points.
     */
    public function getPoints(): int|array
    {
        $highEqualsLow = $this->highEqualToLow();
        $rules = new Rules();

        if ($rules->bust($this->handPoints["high"]) or $highEqualsLow) {
            return $this->handPoints["low"];
        }

        return $this->handPoints;
    }

    /**
     * Returns int with player's low points.
     *
     * @return int with player low points.
     */
    public function getLowPoints(): int
    {
        return $this->handPoints["low"];
    }

    /**
     * Returns int with player's high points.
     *
     * @return int with player high points.
     */
    public function getHighPoints(): int
    {
        return $this->handPoints["high"];
    }
}
