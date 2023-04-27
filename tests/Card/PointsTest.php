<?php

/**
 * Test class for Points class with seed for shuffleDeck
 * to make the tests more predictable without mocks/stubs.
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class PointsTest extends TestCase
{
    /**
     * @var Deck $deck Deck of cards.
     */
    private Deck $deck;

    /**
     * @var Hand $hand Hand with cards.
     */
    private Hand $hand;

    /**
     * @var Points $points Points class.
     */
    private Points $points;

    /**
     * Set up run before every test case
     */
    protected function setUp() : void
    {
        $this->deck = new Deck();

        $this->hand = new Hand();

        $this->points = new Points();
    }

    /**
     * Verify that high points is as expected.
     */
    public function testCalculatePointsHigh() : void
    {
        $this->deck->shuffleDeck(1);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $exp = 10;
        $res = $this->points->getHighPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that low points is as expected.
     */
    public function testCalculatePointsLow() : void
    {
        $this->deck->shuffleDeck(1);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $exp = 10;
        $res = $this->points->getLowPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that high points is as expected when one ace is among hand cards.
     */
    public function testCalculatePointsWithOneAceHigh() : void
    {
        $this->deck->shuffleDeck(3);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $exp = 19;
        $res = $this->points->getHighPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that high points is as expected when two aces are among hand cards.
     */
    public function testCalculatePointsWithTwoAcesHigh() : void
    {
        $this->deck->shuffleDeck(14);

        for($i = 0; $i < 4; $i++){
            $card = $this->deck->drawSingle();

            $this->hand->addCard($card);
        }

        $this->points->calculatePoints($this->hand);

        $card = $this->deck->drawSingle();
        $this->hand->addCard($card);

        $card = $this->deck->drawSingle();
        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $exp = 21;
        $res = $this->points->getHighPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that high points is equal to low points.
     */
    public function testHighEqualsLowTrue() : void
    {
        $this->deck->shuffleDeck(1);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $res = $this->points->highEqualToLow();

        $this->assertTrue($res);
    }

    /**
     * Verify that high points is not equal to low points.
     */
    public function testHighEqualsLowFalse() : void
    {
        $this->deck->shuffleDeck(3);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $res = $this->points->highEqualToLow();

        $this->assertFalse($res);
    }

    /**
     * Verify that best hand is set and gotten correctly to high points.
     */
    public function testSetAndGetBestHandPointsHigh() : void
    {
        $this->deck->shuffleDeck(3);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $card = $this->deck->drawSingle();

        $this->hand->addCard($card);

        $this->points->calculatePoints($this->hand);

        $this->points->setBestHandPoints();

        $exp = 19;
        $this->assertEquals($exp, $this->points->getBestHandPoints());
    }

    /**
     * Verify that best hand is set and gotten correctly to low points.
     */
    public function testSetAndGetBestHandPointsLow() : void
    {
        $this->deck->shuffleDeck(3);

        for($i = 0; $i < 4; $i++){
            $card = $this->deck->drawSingle();

            $this->hand->addCard($card);
        }

        $this->points->calculatePoints($this->hand);

        $this->points->setBestHandPoints();

        $exp = 28;
        $this->assertEquals($exp, $this->points->getBestHandPoints());
    }

    /**
     * Verify that get Points method returns integer.
     */
    public function testGetPointsReturnInteger() : void
    {
        $this->deck->shuffleDeck(3);

        for($i = 0; $i < 4; $i++){
            $card = $this->deck->drawSingle();

            $this->hand->addCard($card);
        }

        $this->points->calculatePoints($this->hand);

        $res = $this->points->getPoints();

        $this->assertIsInt($res);
    }

    /**
     * Verify that get Points method returns integer.
     */
    public function testGetPointsReturnArray() : void
    {
        $this->deck->shuffleDeck(3);

        for($i = 0; $i < 2; $i++){
            $card = $this->deck->drawSingle();

            $this->hand->addCard($card);
        }

        $this->points->calculatePoints($this->hand);

        $res = $this->points->getPoints();

        $this->assertIsArray($res);
    }
}
