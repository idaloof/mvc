<?php

/**
 * Test suite for StraightEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class StraightEvaluatorTest extends TestCase
{
    /**
     * Verify that a StraightEvaluator returns "Straight" when no special array.
     */
    public function testEvaluateReturnStringNoSpecial() : void
    {
        $evaluator = new StraightEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "14", "12", "10", "11"];
        $ranks = ["K", "A", "Q", "10", "J"];

        $exp = "Straight";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a StraightEvaluator returns "Straight" when special array.
     */
    public function testEvaluateReturnStringSpecial() : void
    {
        $evaluator = new StraightEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["2", "14", "5", "4", "3"];
        $ranks = ["2", "A", "5", "4", "3"];

        $exp = "Straight";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a StraightEvaluator returns empty string.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new StraightEvaluator();
        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "13", "14"];
        $ranks = ["Q", "10", "9", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }
}