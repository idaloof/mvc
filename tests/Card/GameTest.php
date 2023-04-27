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
        $humanHand      = new Hand();
        $humanPoints    = new Points();
        $bankHand       = new Hand();
        $bankPoints     = new Points();
        $deck           = new Deck();
        $human          = new Player($humanHand, $humanPoints);
        $bank           = new Bank($bankHand, $bankPoints);
        $rules          = new Rules();
        $this->game     = new Game($deck, $human, $bank, $rules);
    }

    /**
     * Verify that game property is of instance game object
     */
    public function testCreateGameObject()
    {
        $this->assertInstanceOf("App\Card\Game", $this->game);
    }

    /**
     * Verify that game turn is set to human player.
     */
    public function testSetTurnHuman()
    {
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $player = $state["turn"];
        $playerName = $player->getName();

        $this->assertEquals("human", $playerName);
    }
}
