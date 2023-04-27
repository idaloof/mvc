<?php

/**
 * Test class for Game class
 */

namespace App\Card;

use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    /**
     * @var Game $game Game class.
     */
    private Game $game;

    /**
     * Set up run before every test case
     */
    protected function setUp(): void
    {
        $humanHand      = $this->createMock(Hand::class);
        $humanPoints    = $this->createMock(Points::class);
        $bankHand       = $this->createMock(Hand::class);
        $bankPoints     = $this->createMock(Points::class);
        $deck           = $this->createMock(Deck::class);
        $human          = new Player($humanHand, $humanPoints);
        $bank           = new Bank($bankHand, $bankPoints);
        $rules          = $this->createMock(Rules::class);
        $this->game     = new Game($deck, $human, $bank, $rules);
    }

    // /**
    //  * Verify that game turn is set to human player.
    //  */
    // public function testSetTurnHuman()
    // {
    //     $this->game->setTurn("human");
    //     $state = $this->game->getGameState();

    //     $player = $state["turn"];
    //     $playerName = $player->getName();

    //     $this->assertEquals("human", $playerName);
    // }
}
