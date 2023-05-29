<?php

/**
 * Test suite for GameData class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class GameDataTest extends TestCase
{
    /**
     * @var GameData $gameData Card to run tests for
     */

    private GameData $gameData;

    /**
     * Set up before each test
     */
    protected function setUp() : void
    {
        $this->gameData = new GameData();
    }

    /**
     * Verify that GameData sets and gets correct player names.
     */
    public function testSetAndGetPlayers() : void
    {
        $this->gameData->setPlayers(["Martin"]);

        $exp = ["Martin"];

        $res = $this->gameData->getPlayers();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct player hands.
     */
    public function testSetAndGetPlayerHands() : void
    {
        $playerHands = [
            ["AH", "AS", "AH", "AD", "KH"],
            ["AH", "AS", "AH", "AD", "KD"],
            ["AH", "AS", "AH", "AD", "KS"]
        ];

        $this->gameData->setPlayerHands($playerHands);

        $exp = 3;

        $res = count($this->gameData->getPlayerHands());

        $this->assertEquals($exp, $res);

        $exp = "KD";

        $res = $this->gameData->getPlayerHands()[1][4];

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct game stage.
     */
    public function testSetAndGetGameStage() : void
    {
        $this->gameData->setGameStage("flop");

        $exp = "flop";

        $res = $this->gameData->getGameStage();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct initial buy-in.
     */
    public function testSetAndGetBuyIn() : void
    {
        $this->gameData->setInitialBuyIn(1000);

        $exp = 1000;

        $res = $this->gameData->getInitialBuyIn();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct pot.
     */
    public function testSetAndGetPot() : void
    {
        $this->gameData->setPot(1000);

        $exp = 1000;

        $res = $this->gameData->getPot();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct community cards.
     */
    public function testSetAndGetCommunityCards() : void
    {
        $cards = ["AH", "AS", "AH", "AD", "KH"];

        $this->gameData->setCommunityCards($cards);

        $exp = ["AH", "AS", "AH", "AD", "KH"];

        $res = $this->gameData->getCommunityCards();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct winner hand.
     */
    public function testSetAndGetWinnerHand() : void
    {
        $cards = ["AH", "AS", "AH", "AD", "KH"];

        $this->gameData->setRoundWinnerHand($cards);

        $exp = ["AH", "AS", "AH", "AD", "KH"];

        $res = $this->gameData->getRoundWinnerHand();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct winner name.
     */
    public function testSetAndGetWinnerPlayer() : void
    {
        $this->gameData->setRoundWinner("Martin");

        $exp = "Martin";

        $res = $this->gameData->getRoundWinner();

        $this->assertEquals($exp, $res);
    }
}