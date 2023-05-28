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
        $high = new HighCardEvaluator();
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
            $royal,
            $straightFlush,
            $four,
            $flush, 
            $straight,
            $three,
            $full,
            $two,
            $one,
            $high
        ];
    }

    /**
     * Verify that a HandEvaluator object is created with the create method.
     * @SuppressWarnings(PHPMD)
     */
    public function testCreateObjectThroughServices() : void
    {
        /**
         * @var \traversable<EvaluatorInterface> $evaluators
         */

        $evaluators = [
            $this->createMock(EvaluatorInterface::class),
            $this->createMock(EvaluatorInterface::class)
        ];

        $handEvaluator = HandEvaluator::create($evaluators);

        $this->assertInstanceOf(HandEvaluator::class, $handEvaluator);
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
        $res = $evaluator->evaluateHand($suits, $values, $ranks)[0];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HandEvaluator returns "High card".
     */
    public function testEvaluateReturnHighCard() : void
    {
        $evaluator = new HandEvaluator($this->evaluators);
        $suits = ["D", "H", "D", "D", "H"];
        $values = ["12", "10", "9", "13", "14"];
        $ranks = ["Q", "10", "9", "K", "A"];

        $exp = "High Card";
        $res = $evaluator->evaluateHand($suits, $values, $ranks)[0];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HandEvaluator returns "Straight Flush".
     */
    public function testEvaluateReturnStraightFlush() : void
    {
        $evaluator = new HandEvaluator($this->evaluators);
        $suits = ["D", "D", "D", "D", "D"];
        $values = ["12", "10", "9", "13", "11"];
        $ranks = ["Q", "10", "9", "K", "J"];

        $exp = "Straight Flush";
        $res = $evaluator->evaluateHand($suits, $values, $ranks)[0];

        $this->assertEquals($exp, $res);
    }
}