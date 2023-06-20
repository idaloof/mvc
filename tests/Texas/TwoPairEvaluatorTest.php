<?php

/**
 * Test suite for TwoPairEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TwoPairEvaluatorTest extends TestCase
{
    /**
     * Verify that a TwoPairEvaluator returns "Two Pair".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new TwoPairEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "12", "14", "12", "13"];
        $ranks = ["K", "Q", "A", "Q", "K"];

        $exp = "Two Pair";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a TwoPairEvaluator returns empty string when full house.
     */
    public function testEvaluateReturnEmptyFullHouse() : void
    {
        $evaluator = new TwoPairEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["13", "14", "14", "13", "14"];
        $ranks = ["K", "A", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a TwoPairEvaluator returns empty string when four of a kind.
     */
    public function testEvaluateReturnEmptyFourOfAKind() : void
    {
        $evaluator = new TwoPairEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["14", "14", "14", "13", "14"];
        $ranks = ["A", "A", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a TwoPairEvaluator returns empty string when no hand.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new TwoPairEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["10", "13", "12", "2", "14"];
        $ranks = ["10", "K", "Q", "2", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that an evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $evaluator = new TwoPairEvaluator();
        $ranks = ["2", "3", "3", "14", "14"];

        $exp = 3396857390347.159;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["11", "11", "13", "13", "12"];

        $exp = 3185055594924.396;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["12", "12", "13", "13", "2"];

        $exp = 3225499298995.159;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["2", "2", "9", "9", "3"];

        $exp = 3001977006784.045;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["7", "7", "8", "8", "14"];

        $exp = 3000577926823.348;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that an evaluator returns correct points.
     */
    public function testCalculateKickerPoints() : void
    {
        $evaluator = new TwoPairEvaluator();
        $kickers = ["12", "13", "11"];

        $exp = 1460.0712979999998;
        $res = $evaluator->calculateKickerPoints($kickers);

        $this->assertEquals($exp, $res);
    }
}