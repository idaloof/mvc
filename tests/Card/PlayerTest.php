<?php

/**
 * Test class for Player class
 */

namespace App\Card;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * @var Player $player Class representing the human player.
     */
    private Player $player;

    /**
     * Set up run before every test case
     */
    protected function setUp() : void
    {
        $hand = new Hand();
        $points = new Points();
        $this->player = new Player($hand, $points);

        $deck = new Deck();
        $deck->shuffleDeck(3);

        for($i = 0; $i < 2; $i++){
            $card = $deck->drawSingle();

            $this->player->addCardToPlayerHand($card);
        }
    }

    /**
     * Verify that player object is instantiated
     */
    public function testCreatePlayerObject() : void
    {
        $hand = new Hand();
        $points = new Points();
        $player = new Player($hand, $points);

        $this->assertInstanceOf("App\Card\Player", $player);
    }

    /**
     * Verify that setName method works correctly.
     */
    public function testSetAndGetName() : void
    {
        $this->player->setName("Martin");
        $res = $this->player->getName();

        $this->assertEquals("Martin", $res);
    }

    /**
     * Verify that getName method returns "human" if set method not used.
     */
    public function testGetName() : void
    {
        $res = $this->player->getName();

        $this->assertEquals("human", $res);
    }

    /**
     * Verify that card is added, points are calculated, set and returned correctly.
     */
    public function testCalculateSetAndGetPoints() : void
    {
        $this->player->calculatePlayerPoints();
        $this->player->setPlayerDefinitivePoints();

        $exp = 19;
        $res = $this->player->getPlayerDefinitivePoints();

        $this->assertEquals($exp, $res);

        $exp = [
            "low" => 9,
            "high" => 19
        ];

        $res = $this->player->getPlayerPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player low points is correctly calculated.
     */
    public function testPlayerGetLowPoints() : void
    {
        $this->player->calculatePlayerPoints();

        $exp = 9;

        $res = $this->player->getPlayerLowPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player high points is correctly calculated.
     */
    public function testPlayerGetHighPoints() : void
    {
        $this->player->calculatePlayerPoints();

        $exp = 19;

        $res = $this->player->getPlayerHighPoints();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player hand contains correct card values.
     */
    public function testGetPlayerCardValues() : void
    {
        $exp = ["A", "8"];

        $res = $this->player->getPlayerCardValues();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that player hand contains correct card images.
     */
    public function testGetPlayerCardImages() : void
    {
        $exp = ["AD", "8S"];

        $res = $this->player->getPlayerCardImages();

        $this->assertEquals($exp, $res);
    }
}
