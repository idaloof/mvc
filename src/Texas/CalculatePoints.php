<?php

/**
 * This abstract class provides the evaluator classes with the same set
 * of constants - the rank points and the hand points.
 */

namespace App\Texas;

abstract class CalculatePoints
{
    protected const RANK_POINTS = [
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
        'T' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    protected const HAND_POINTS = [
        'High Card' => 1000000000000,
        'One Pair' => 2000000000000,
        'Two Pair' => 3000000000000,
        'Three Of A Kind' => 4000000000000,
        'Straight' => 5000000000000,
        'Flush' => 6000000000000,
        'Full House' => 7000000000000,
        'Four Of A Kind' => 8000000000000,
        'Straight Flush' => 9000000000000,
        'Royal Straight Flush' => 10000000000000
    ];
}
