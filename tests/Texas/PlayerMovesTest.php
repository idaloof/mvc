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
     * Verify that PlayerMoves sets moves and gets correct array of moves.
     */
    public function testSetAndGetMoves() : void
    {
        $this->moves->addToRoundMoves("check");
        $this->moves->addToRoundMoves("raise");
        $this->moves->addToRoundMoves("call");

        $exp = [
            "check",
            "raise",
            "call"
        ];

        $res = $this->moves->getRoundMoves() ;

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that PlayerMoves object can clear player moves.
     */
    public function testClearMoves() : void
    {
        $this->moves->addToRoundMoves("check");
        $this->moves->addToRoundMoves("raise");
        $this->moves->addToRoundMoves("call");

        $exp = [
            "check",
            "raise",
            "call"
        ];

        $res = $this->moves->getRoundMoves() ;

        $this->assertEquals($exp, $res);

        $this->moves->clearRoundMoves();

        $exp = [];

        $res = $this->moves->getRoundMoves();

        $this->assertEquals($exp, $res);
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