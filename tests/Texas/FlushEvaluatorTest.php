<?php

/**
 * Test suite for FlushEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class FlushEvaluatorTest extends TestCase
{
    /**
     * Verify that a FlushEvaluator returns "Flush".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new FlushEvaluator();
        $suits = ["D", "D", "D", "D", "D"];
        $values = ["13", "10", "11", "12", "14"];
        $ranks = ["K", "K", "A", "K", "A"];

        $exp = "Flush";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a FlushEvaluator returns empty string.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new FlushEvaluator();
        $suits = ["D", "H", "D", "D", "D"];
        $values = ["13", "10", "11", "12", "14"];
        $ranks = ["K", "K", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $evaluator = new FlushEvaluator();
        $values = ["13", "11", "12", "10", "14"];

        $exp = 660;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }
}