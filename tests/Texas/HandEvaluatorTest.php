<?php

namespace App\Texas;
use PHPUnit\Framework\TestCase;

/**
 * Test suite for HandEvaluator class
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */

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
     * @SuppressWarnings(PHPMD)
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
     * @SuppressWarnings(PHPMD)
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
     * @SuppressWarnings(PHPMD)
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

    /**
     * Verify that a HandEvaluator returns correct array of strings.
     * @SuppressWarnings(PHPMD)
     */
    public function testReturnSuitsAsString() : void
    {
        $evaluator = new HandEvaluator($this->evaluators);
        $card = $this->createMock(CardInterface::class);
        $card->method('getCardSuit')->willReturn("C");

        /**
         * @var array<Card> $cards
         */
        $cards = [
            $card,
            $card,
            $card,
            $card
        ];
        $exp = ["C", "C", "C", "C"];
        $res = $evaluator->cardSuitsToString($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HandEvaluator returns correct array of strings.
     * @SuppressWarnings(PHPMD)
     */
    public function testReturnValuesAsString() : void
    {
        $evaluator = new HandEvaluator($this->evaluators);
        $card = $this->createMock(CardInterface::class);
        $card->method('getCardValue')->willReturn("14");

        /**
         * @var array<Card> $cards
         */
        $cards = [
            $card,
            $card,
            $card,
            $card
        ];

        $exp = ["14", "14", "14", "14"];
        $res = $evaluator->cardValuesToString($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HandEvaluator returns correct array of strings.
     * @SuppressWarnings(PHPMD)
     */
    public function testReturnRanksAsString() : void
    {
        $evaluator = new HandEvaluator($this->evaluators);
        $card = $this->createMock(CardInterface::class);
        $card->method('getCardRank')->willReturn("A");

        /**
         * @var array<Card> $cards
         */
        $cards = [
            $card,
            $card,
            $card,
            $card
        ];

        $exp = ["A", "A", "A", "A"];
        $res = $evaluator->cardRanksToString($cards);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that a HandEvaluator returns correct array hand names and points.
     * @SuppressWarnings(PHPMD)
     */
    public function testEvaluateManyHands(): void
    {
        // Create a mock HandEvaluator object
        $evaluator1 = $this->createMock(EvaluatorInterface::class);
        $evaluator1->method('evaluateHand')->willReturn("One Pair");
        $evaluator1->method('calculatePoints')->willReturn(10.6);

        $evaluator2 = $this->createMock(EvaluatorInterface::class);
        $evaluator2->method('evaluateHand')->willReturn("High Card");
        $evaluator2->method('calculatePoints')->willReturn(5.5);

        // Create a mock Card object
        $card1 = $this->createMock(Card::class);
        $card2 = $this->createMock(Card::class);

        // Create a mock HandEvaluator object and inject the mock evaluators
        $handEvaluator = new HandEvaluator([$evaluator1, $evaluator2]);

        // Create an array of mock hands
        $hand1 = [
            $card1,
            $card1,
            $card1,
            $card1,
            $card1
        ];

        $hand2 = [
            $card2,
            $card2,
            $card2,
            $card2,
            $card2
        ];

        $hands = [$hand1, $hand2];

        // Call the evaluateManyHands method
        $result = $handEvaluator->evaluateManyHands($hands);

        // Assert the expected result
        $expected = [
            [10.6, 'One Pair', $hand1],
            [10.6, 'One Pair', $hand1],
            [5.5, 'High Card', $hand2],
            [5.5, 'High Card', $hand2],
        ];

        $this->assertEquals($expected, $result);
    }
}