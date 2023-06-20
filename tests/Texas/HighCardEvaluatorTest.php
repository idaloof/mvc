<?php

/**
 * Test suite for HighCardEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class HighCardEvaluatorTest extends TestCase
{
    /**
     * Verify that a HighCardEvaluator returns empty string.
     */
    public function testEvaluateReturnEmptyString() : void
    {
        $evaluator = new HighCardEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "13", "12", "11", "10"];
        $ranks = ["K", "K", "Q", "J", "10"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HighCardEvaluator returns "High Card".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new HighCardEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["2", "13", "12", "11", "10"];
        $ranks = ["2", "K", "Q", "J", "10"];

        $exp = "High Card";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $evaluator = new HighCardEvaluator();
        $values = ["9", "11", "12", "10", "14"];

        $exp = 1000000002263.176;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);

        $values = ["2", "3", "13", "10", "14"];

        $exp = 1000000002391.527;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }
}