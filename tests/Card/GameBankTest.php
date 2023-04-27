<?php

/**
 * Test class for Game class
 */

namespace App\Card;

use PHPUnit\Framework\TestCase;

class GameBankTest extends TestCase
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

        $deck->shuffleDeck(3); // Let's me know that the first three cards are A, 8 and 9.

        $human          = new Player($humanHand, $humanPoints);
        $bank           = new Bank($bankHand, $bankPoints);
        $rules          = new Rules();
        $this->game     = new Game($deck, $human, $bank, $rules);
    }

    /**
     * Verify that game property is of instance game object
     */
    public function testCreateGameObject() : void
    {
        $this->assertInstanceOf("App\Card\Game", $this->game);
    }

    /**
     * Verify that game turn is set to bank player.
     */
    public function testSetTurnBank() : void
    {
        $this->game->setTurn("bank");
        $state = $this->game->getGameState();

        $player = $state["turn"];
        $playerName = $player->getName();

        $this->assertEquals("bank", $playerName);
    }

    /**
     * Verify that human player low points is set correctly.
     */
    public function testCalculateAndSetLowPointsBank() : void
    {
        $this->game->setTurn("bank");
        $state = $this->game->getGameState();

        $exp = 9;
        $res = $state["bankLowPoints"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that human player high points is set correctly.
     */
    public function testCalculateAndSetHighPointsBank() : void
    {
        $this->game->setTurn("bank");
        $state = $this->game->getGameState();

        $exp = 19;
        $res = $state["bankHighPoints"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that human player final points is set correctly.
     */
    public function testCalculateAndSetFinalPointsBank() : void
    {
        $this->game->setTurn("bank");
        $this->game->setTurn("bank");
        $this->game->setTurn("bank");
        $state = $this->game->getGameState();

        $exp = 28;
        $res = $state["bankPoints"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player bust is correctly
     * set to true when over 21 points.
     */
    public function testGetAndSetBustBankAndHumanWinner() : void
    {
        $this->game->setTurn("bank");
        $this->game->setTurn("bank");
        $this->game->setTurn("bank");
        $this->game->setTurn("bank");
        $state = $this->game->getGameState();

        $exp = true;
        $res = $state["bankBust"];

        $this->assertEquals($exp, $res);

        $exp = "Du";
        $res = $state["winner"];

        $this->assertEquals($exp, $res);

        $exp = "Banken blev tjock.";
        $res = $state["message"];

        $this->assertEquals($exp, $res);

        $exp = "Yes.";
        $res = $state["winnerDecided"];

        $this->assertEquals($exp, $res);
    }
}
