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
}