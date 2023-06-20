<?php

/**
 * Test suite for StraightFlushEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class StraightFlushEvaluatorTest extends TestCase
{
    /**
     * Verify that a StraightFlushEvaluator returns "Straight Flush".
     */
    public function testEvaluateReturnString() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new StraightFlushEvaluator($straight, $flush);

        $suits = ["D", "D", "D", "D", "D"];
        $values = ["9", "13", "12", "11", "10"];
        $ranks = ["9", "K", "Q", "J", "10"];

        $exp = "Straight Flush";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a StraightFlushEvaluator returns empty string.
     */
    public function testEvaluateReturnEmptyNoAceAndKing() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new StraightFlushEvaluator($straight, $flush);

        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "11", "8"];
        $ranks = ["Q", "10", "9", "J", "8"];

        $exp = "";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a StraightFlushEvaluator returns empty string.
     */
    public function testEvaluateReturnEmptyAceAndKing() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new StraightFlushEvaluator($straight, $flush);

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
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new StraightFlushEvaluator($straight, $flush);

        $values = ["13", "11", "12", "10", "14"];

        $exp = 9000000003035.861;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPointsSpecial() : void
    {
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $evaluator = new StraightFlushEvaluator($straight, $flush);

        $values = ["2", "14", "5", "4", "3"];

        $exp = 9000000000000.463;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }
}