<?php

/**
 * This class is for evaluating if a hand has a four of a kind
 */

namespace App\Texas;

class FourOfAKindEvaluator extends CalculatePoints implements EvaluatorInterface
{
    /**
     * Returns four of a kind if hand has it or empty string if not.
     *
     * @param array<string>  $suits      Suits of the player's cards.
     * @param array<string>  $values     Values of the player's cards.
     * @param array<string>  $ranks      Ranks of the player's cards.
     *
     * @return string                   "Four Of A Kind" or empty string.
     *
     */
    public function evaluateHand(array $suits, array $values, array $ranks): string
    {
        $counts = array_count_values($ranks);

        foreach ($ranks as $rank) {
            if ($counts[$rank] === 4) {
                return "Four Of A Kind";
            }
        }

        return "";
    }

    /**
     * Calculates and returns the points for a hand.
     *
     * @param array<string> $values Values of the player's cards.
     *
     * @return float                  Number of points obtained from hand.
     */
    public function calculatePoints(array $values): float
    {
        $points = 0;

        $counts = array_count_values($values);

        $kickers = [];

        foreach ($counts as $key => $value) {
            if ($value === 1) {
                $kickers[] = $key;
            } elseif ($value === 4) {
                $points += (intval($key)**12) * 7000 / 1000000;
            }
        }

        $points += $this->calculateKickerPoints($kickers);

        $points += self::HAND_POINTS["Four Of A Kind"];

        $points = sprintf("%.3f", $points);
        $points = floatval($points);

        return $points;
    }

    /**
     * Calculates points for all kickers.
     *
     * @param array<string> $kickers
     *
     * @return float Points for all kickers.
     */
    public function calculateKickerPoints(array $kickers): float
    {
        $points = 0;

        foreach ($kickers as $kicker) {
            $points += ($kicker**8) / 10**6;
        }

        return $points;
    }
}
