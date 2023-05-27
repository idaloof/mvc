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
    public function testGet() : void
    {
        $this->gameData->setPlayers(["Martin"]);

        $exp = ["Martin"];

        $res = $this->gameData->getPlayers();

        $this->assertEquals($exp, $res);
    }
}