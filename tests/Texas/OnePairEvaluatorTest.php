<?php

/**
 * Test suite for OnePairEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class OnePairEvaluatorTest extends TestCase
{
    /**
     * Verify that a OnePairEvaluator returns "One Pair".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new OnePairEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "13", "12", "11", "10"];
        $ranks = ["K", "K", "Q", "J", "10"];

        $exp = "One Pair";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a TwoPairEvaluator returns empty string when three of a kind.
     */
    public function testEvaluateReturnEmptyThreeOfAKind() : void
    {
        $evaluator = new OnePairEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "12", "14", "12", "13"];
        $ranks = ["K", "K", "A", "Q", "K"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a TwoPairEvaluator returns empty string when two pair.
     */
    public function testEvaluateReturnEmptyTwoPair() : void
    {
        $evaluator = new OnePairEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "12", "14", "12", "13"];
        $ranks = ["K", "Q", "A", "Q", "K"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a TwoPairEvaluator returns empty string when full house.
     */
    public function testEvaluateReturnEmptyFullHouse() : void
    {
        $evaluator = new OnePairEvaluator();
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
        $evaluator = new OnePairEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["14", "14", "14", "13", "14"];
        $ranks = ["A", "A", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a OnePairEvaluator returns empty string when no hand.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new OnePairEvaluator();
        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "13", "14"];
        $ranks = ["Q", "10", "9", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $evaluator = new OnePairEvaluator();
        $ranks = ["12", "14", "14", "13", "11"];

        $exp = 2396857388087.144;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["12", "13", "14", "13", "11"];

        $exp = 2163086597977.497;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["12", "13", "14", "2", "2"];

        $exp = 2000000002750.174;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);

        $ranks = ["5", "4", "2", "3", "3"];

        $exp = 2000000003720.543;
        $res = $evaluator->calculatePoints($ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testCalculateKickerPoints() : void
    {
        $evaluator = new OnePairEvaluator();
        $kickers = ["12", "13", "11"];

        $exp = 1460.0712979999998;
        $res = $evaluator->calculateKickerPoints($kickers);

        $this->assertEquals($exp, $res);
    }
}