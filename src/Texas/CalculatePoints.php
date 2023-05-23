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
        '10' => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14,
    ];

    protected const HAND_POINTS = [
        'High Card' => 1,
        'One Pair' => 2,
        'Two Pair' => 3,
        'Three Of A Kind' => 4,
        'Straight' => 5,
        'Flush' => 6,
        'Full House' => 7,
        'Four Of A Kind' => 8,
        'Straight Flush' => 9,
        'Royal Straight Flush' => 10
    ];
}
