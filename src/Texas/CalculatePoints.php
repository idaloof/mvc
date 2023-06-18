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
        'High Card' => 10000,
        'One Pair' => 20000,
        'Two Pair' => 30000,
        'Three Of A Kind' => 40000,
        'Straight' => 50000,
        'Flush' => 60000,
        'Full House' => 70000,
        'Four Of A Kind' => 80000,
        'Straight Flush' => 90000,
        'Royal Straight Flush' => 100000
    ];
}
