<?php

/**
 * Test suite for HighCardEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class HighCardEvaluatorTest extends TestCase
{
    /**
     * Verify that a evaluator returns correct points.
     */
    public function testEvaluateReturnPoints() : void
    {
        $evaluator = new HighCardEvaluator();
        $values = ["9", "11", "12", "10", "14"];

        $exp = 156;
        $res = $evaluator->calculatePoints($values);

        $this->assertEquals($exp, $res);
    }
}