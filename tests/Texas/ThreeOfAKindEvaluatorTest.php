<?php

/**
 * Test suite for ThreeOfAKindEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class ThreeOfAKindEvaluatorTest extends TestCase
{
    /**
     * Verify that a ThreeOfAKindEvaluator returns "Three Of A Kind".
     */
    public function testEvaluateReturnString() : void
    {
        $evaluator = new ThreeOfAKindEvaluator();
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "12", "14", "13", "13"];
        $ranks = ["K", "Q", "A", "K", "K"];

        $exp = "Three Of A Kind";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a ThreeOfAKindEvaluator returns empty string when full house.
     */
    public function testEvaluateReturnEmptyFullHouse() : void
    {
        $evaluator = new ThreeOfAKindEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["13", "14", "14", "13", "14"];
        $ranks = ["K", "A", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a ThreeOfAKindEvaluator returns empty string.
     */
    public function testEvaluateReturnEmptyFourOfAKind() : void
    {
        $evaluator = new ThreeOfAKindEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["14", "14", "14", "13", "14"];
        $ranks = ["A", "A", "A", "K", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a ThreeOfAKindEvaluator returns empty string.
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new ThreeOfAKindEvaluator();
        $suits = ["D", "H", "C", "C", "S"];
        $values = ["10", "13", "12", "2", "14"];
        $ranks = ["10", "K", "Q", "2", "A"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $evaluator = new ThreeOfAKindEvaluator();
        $values = ["12", "9", "14", "14", "14"];

        $exp = 40077;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }
}