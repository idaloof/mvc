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
        $player1 = new TexasPlayer("Martin", 20, 20);
        $player2 = new TexasPlayer("Olf", 20, 20);

        $this->gameData->setPlayers([$player1, $player2]);

        $exp = "Martin";

        $res = $this->gameData->getPlayers()[0]->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct game stage.
     */
    public function testSetAndGetGameStage() : void
    {
        $this->gameData->setGameStage(3);

        $exp = "flop";

        $res = $this->gameData->getGameStage();

        $this->assertEquals($exp, $res);

        $this->gameData->setGameStage(4);

        $exp = "turn";

        $res = $this->gameData->getGameStage();

        $this->assertEquals($exp, $res);

        $this->gameData->setGameStage(5);

        $exp = "river";

        $res = $this->gameData->getGameStage();

        $this->assertEquals($exp, $res);

        $this->gameData->setGameStage(0);

        $exp = "pre-flop";

        $res = $this->gameData->getGameStage();

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
        $card1 = new Card("Ace of clubs", "AC", "C", "A", "14");
        $card2 = new Card("Ace of clubs", "AC", "C", "A", "14");
        $card3 = new Card("Ace of clubs", "AC", "C", "A", "14");

        $cards = [$card1, $card2, $card3];

        $this->gameData->setCommunityCards($cards);

        $exp = 3;

        $res = count($this->gameData->getCommunityCards());

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct winner hand.
     */
    public function testSetAndGetWinnerHand() : void
    {
        $card1 = new Card("Ace of clubs", "AC", "C", "A", "14");
        $card2 = new Card("Ace of clubs", "AC", "C", "A", "14");
        $card3 = new Card("Ace of clubs", "AC", "C", "A", "14");
        $card4 = new Card("Ace of clubs", "AC", "C", "A", "14");
        $card5 = new Card("Ace of clubs", "AC", "C", "A", "14");

        $cards = [$card1, $card2, $card3, $card4, $card5];

        $this->gameData->setRoundWinnerHand($cards);

        $exp = 5;

        $res = count($this->gameData->getRoundWinnerHand());

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that GameData sets and gets correct winner name.
     */
    public function testSetAndGetWinnerPlayer() : void
    {
        $player = new TexasPlayer("Martin", 20, 20);

        $this->gameData->setRoundWinner($player);

        $exp = "Martin";

        $res = $this->gameData->getRoundWinner()->getName();

        $this->assertEquals($exp, $res);
    }
}