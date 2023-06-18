<?php

/**
 * Test suite for FullHouseEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class FullHouseEvaluatorTest extends TestCase
{
    /**
     * Verify that a FullHouseEvaluator returns "Full House".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new FullHouseEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "13", "14", "13", "13"];
        $ranks = ["K", "A", "A", "K", "K"];

        $exp = "Full House";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a FullHouseEvaluator returns empty string.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new FullHouseEvaluator();
        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "14", "13", "14"];
        $ranks = ["Q", "10", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that evaluator returns correct points.
     */
    public function testEvaluateReturnPointsAces() : void
    {
        $evaluator = new FullHouseEvaluator();
        $values = ["5", "14", "5", "14", "14"];

        $exp = 70052;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that evaluator returns correct points.
     */
    public function testEvaluateReturnPointsTwos() : void
    {
        $evaluator = new FullHouseEvaluator();
        $values = ["12", "12", "2", "2", "2"];

        $exp = 70030;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }
}