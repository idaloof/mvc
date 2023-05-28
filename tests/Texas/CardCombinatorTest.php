<?php

/**
 * Test suite for CardCombinator class
 */

namespace App\Texas;

use PHPUnit\Framework\TestCase;

class CardCombinatorTest extends TestCase
{
    /**
     * Verifies that only one combination of cards is returned
     * when using a set of 5 cards and also setting the
     * hand size to 5 cards.
     */
    public function testCombinatorFiveCards(): void
    {
        $combinator = new CardCombinator();

        /**
         * @var array<Card> $cards
         */
        $cards = [
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class)
        ];

        $combinations = $combinator->setAndGetCombinations($cards);

        $exp = 1;

        $res = count($combinations);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that six combinations of five cards is returned
     * when using a set of 6 cards and also setting the
     * hand size to 5 cards.
     */
    public function testCombinatorSixCards(): void
    {
        $combinator = new CardCombinator();

        /**
         * @var array<Card> $cards
         */
        $cards = [
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class)
        ];

        $combinations = $combinator->setAndGetCombinations($cards);

        $exp = 6;

        $res = count($combinations);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that 21 combinations of five cards is returned
     * when using a set of 7 cards and also setting the
     * hand size to 5 cards.
     */
    public function testCombinatorSevenCards(): void
    {
        $combinator = new CardCombinator();

        /**
         * @var array<Card> $cards
         */
        $cards = [
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class),
            $this->createMock(CardInterface::class)
        ];

        $combinations = $combinator->setAndGetCombinations($cards);

        $exp = 21;

        $res = count($combinations);

        $this->assertEquals($exp, $res);
    }
}