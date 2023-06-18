<?php

/**
 * Test suite for RoyalStraightFlushEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class RoyalStraightFlushEvaluatorTest extends TestCase
{
    /**
     * Verify that a RoyalStraightFlushEvaluator returns "Royal Straight Flush".
     */
    public function testEvaluateReturnString() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new RoyalStraightFlushEvaluator($straight, $flush);

        $suits = ["D", "D", "D", "D", "D"];
        $values = ["14", "13", "12", "11", "10"];
        $ranks = ["A", "K", "Q", "J", "10"];

        $exp = "Royal Straight Flush";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a RoyalStraightFlushEvaluator returns empty string.
     */
    public function testEvaluateReturnEmptyNoAceAndKing() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new RoyalStraightFlushEvaluator($straight, $flush);

        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "11", "8"];
        $ranks = ["Q", "10", "9", "J", "8"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a RoyalStraightFlushEvaluator returns empty string.
     */
    public function testEvaluateReturnEmptyAceAndKing() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new RoyalStraightFlushEvaluator($straight, $flush);

        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "14", "13"];
        $ranks = ["Q", "10", "9", "A", "K"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $ranks = ["A"];
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new RoyalStraightFlushEvaluator($straight, $flush);

        $exp = 100000;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);
    }
}