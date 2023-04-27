<?php

/**
 * Test class for Game class
 */

namespace App\Card;

use PHPUnit\Framework\TestCase;

class GameHumanTest extends TestCase
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
     * Verify that game turn is set to human player.
     */
    public function testSetTurnHuman() : void
    {
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $player = $state["turn"];
        $playerName = $player->getName();

        $this->assertEquals("human", $playerName);
    }

    /**
     * Verify that deck count decreases by 2
     * player is hit with cards twice.
     */
    public function testStartTurn() : void
    {
        $this->game->startTurn();
        $this->game->startTurn();
        $state = $this->game->getGameState();

        $exp = 50;
        $res = $state["deckCount"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that human player low points is set correctly.
     */
    public function testCalculateAndSetLowPointsHuman() : void
    {
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $exp = 1;
        $res = $state["humanLowPoints"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that human player high points is set correctly.
     */
    public function testCalculateAndSetHighPointsHuman() : void
    {
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $exp = 11;
        $res = $state["humanHighPoints"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that human player final points is set correctly.
     */
    public function testCalculateAndSetFinalPointsHuman() : void
    {
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $exp = 18;
        $res = $state["humanPoints"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player probability is correctly
     * calculated and set.
     */
    public function testCalculateAndSetProbability() : void
    {
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $exp = 77.60000000000001;
        $res = $state["bustProbability"];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player bust is correctly
     * set to true when over 21 points.
     */
    public function testGetAndSetBustHumanAndBankWinner() : void
    {
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $this->game->setTurn("human");
        $state = $this->game->getGameState();

        $exp = true;
        $res = $state["humanBust"];

        $this->assertEquals($exp, $res);

        $exp = "Banken";
        $res = $state["winner"];

        $this->assertEquals($exp, $res);

        $exp = "Du blev tjock.";
        $res = $state["message"];

        $this->assertEquals($exp, $res);

        $exp = "Yes.";
        $res = $state["winnerDecided"];

        $this->assertEquals($exp, $res);
    }
}