<?php

/**
 * Test class for Rules class
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class RulesTest extends TestCase
{
    /**
     * @var Rules $rules Methods for rules of the game.
     */
    private Rules $rules;

    /**
     * Set up run before every test case
     */
    protected function setUp() : void
    {
        $this->rules = new Rules();
    }

    /**
     * Tests if bust returns true
     */
    public function testBustReturnsTrue() : void
    {
        $points = 22;
        $res = $this->rules->bust($points);

        $this->assertTrue($res);
    }

    /**
     * Tests if bust returns false
     */
    public function testBustReturnsFalse() : void
    {
        $points = 21;
        $res = $this->rules->bust($points);

        $this->assertFalse($res);
    }

    /**
     * Tests if method returns true for bank points over 17.
     */
    public function testOverSeventeenReturnsTrue() : void
    {
        $points = 18;
        $res = $this->rules->overSeventeen($points);

        $this->assertTrue($res);
    }

    /**
     * Tests if method returns false for bank points over 17.
     */
    public function testOverSeventeenReturnsFalse() : void
    {
        $points = 17;
        $res = $this->rules->overSeventeen($points);

        $this->assertFalse($res);
    }

    /**
     * Verifies that correct string is returned when winner is decided.
     */
    public function testDecideWinner() : void
    {
        $res = $this->rules->decideWinner(20, 19);

        $this->assertEquals("Du", $res);

        $res = $this->rules->decideWinner(19, 19);

        $this->assertEquals("Banken", $res);

        $res = $this->rules->decideWinner(19, 20);

        $this->assertEquals("Banken", $res);
    }
}