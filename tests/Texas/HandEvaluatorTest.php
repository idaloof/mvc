<?php

/**
 * Test suite for HandEvaluator class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class HandEvaluatorTest extends TestCase
{
    /**
     * @var array<EvaluatorInterface> $evaluators Array of hand evaluators.
     */
    private array $evaluators;

    /**
     * Set up run before every test case
     */
    protected function setUp(): void
    {
        $one = new OnePairEvaluator();
        $two = new TwoPairEvaluator();
        $three = new ThreeOfAKindEvaluator();
        $straight = new StraightEvaluator();
        $flush = new FlushEvaluator();
        $full = new FullHouseEvaluator();
        $four = new FourOfAKindEvaluator();
        $straightFlush = new StraightFlushEvaluator($straight, $flush);
        $royal = new RoyalStraightFlushEvaluator($straight, $flush);

        $this->evaluators = [
            $one,
            $two,
            $three,
            $straight,
            $flush, 
            $full,
            $four,
            $straightFlush,
            $royal
        ];
    }

    /**
     * Verify that a HandEvaluator returns correct hand string.
     */
    public function testEvaluateReturnHandString() : void
    {

        $evaluator = new HandEvaluator($this->evaluators);
        $suits = ["H", "D", "D", "C", "S"];
        $values = ["13", "13", "12", "11", "10"];
        $ranks = ["K", "K", "Q", "J", "10"];

        $exp = "One Pair";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HandEvaluator returns "High card".
     */
    public function testEvaluateReturnEmpty() : void
    {
        $evaluator = new HandEvaluator($this->evaluators);
        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "13", "14"];
        $ranks = ["Q", "10", "9", "K", "A"];

        $exp = "High Card";
        $res = $evaluator->evaluateHand($suits, $values, $ranks);

        $this->assertEquals($exp, $res);
    }
}