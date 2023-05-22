<?php

/**
 * Test suite for FourOfAKindEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class FourOfAKindEvaluatorTest extends TestCase
{
    /**
     * Verify that a FourOfAKindEvaluator returns "Four Of A Kind".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new FourOfAKindEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "13", "14", "13", "13"];
        $ranks = ["K", "K", "A", "K", "K"];

        $exp = "Four Of A Kind";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a FourOfAKindEvaluator returns empty string.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new FourOfAKindEvaluator();
        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "14", "13", "14"];
        $ranks = ["Q", "10", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }
}