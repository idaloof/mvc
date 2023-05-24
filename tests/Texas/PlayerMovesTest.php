<?php

/**
 * Test suite for PlayerMoves class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class PlayerMovesTest extends TestCase
{
    /**
     * @var PlayerMoves $moves Moves to run tests for.
     */

    private PlayerMoves $moves;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->moves = new PlayerMoves();
    }

    /**
     * Verify that PlayerMoves setHasFolded sets correct bool.
     */
    public function testSetHasFolded() : void
    {
        $this->moves->setHasFolded();

        $this->assertTrue($this->moves->hasFolded());
    }

    /**
     * Verify that PlayerMoves hasFolded returns correct bool.
     */
    public function testHasFolded() : void
    {
        $this->assertFalse($this->moves->hasFolded());
    }
}