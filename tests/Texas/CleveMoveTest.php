<?php

/**
 * Test suite for Queue class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class CleveMoveTest extends TestCase
{
    /**
     * Verifies that fold method returns correct array.
     */
    public function testCleveFolds() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = ["fold", ""];

        $res = $player->setCleveFolds();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that check method returns correct array.
     */
    public function testCleveChecks() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = ["check", ""];

        $res = $player->setCleveChecks();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that call method returns correct array.
     */
    public function testCleveCalls() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = ["call", 20];

        $res = $player->setCleveCalls(20);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that raise method returns correct array.
     */
    public function testCleveRaises() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = ["raise", 20];

        $res = $player->setCleveRaises(20);

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that set move and data method returns correct array.
     */
    public function testCleveSetAndData() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = ["fold", ""];

        $res = $player->setCleveMoveAndReturnData(
            "fold",
            20,
            20
        );

        $this->assertEquals($exp, $res);

        $exp = ["check", ""];

        $res = $player->setCleveMoveAndReturnData(
            "check",
            20,
            20
        );

        $this->assertEquals($exp, $res);

        $exp = ["call", 20];

        $res = $player->setCleveMoveAndReturnData(
            "call",
            20,
            20
        );

        $this->assertEquals($exp, $res);

        $exp = ["raise", 20];

        $res = $player->setCleveMoveAndReturnData(
            "raise",
            20,
            20
        );

        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that move post method returns correct string.
     */
    public function testCleveMovePost() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = "check";
        $res = $player->setAndGetCleveMovePost(40, 2);
        $this->assertEquals($exp, $res);

        $exp = "raise";
        $res = $player->setAndGetCleveMovePost(60, 2);
        $this->assertEquals($exp, $res);

        $exp = "fold";
        $res = $player->setAndGetCleveMovePost(38, 3);
        $this->assertEquals($exp, $res);

        $exp = "call";
        $res = $player->setAndGetCleveMovePost(80, 3);
        $this->assertEquals($exp, $res);

        $exp = "raise";
        $res = $player->setAndGetCleveMovePost(120, 3);
        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that move pre method returns correct string.
     */
    public function testCleveMovePre() : void
    {
        $player = new ComputerCleve("Cleve", 20);

        $exp = "check";
        $res = $player->setAndGetCleveMovePre(40, 2);
        $this->assertEquals($exp, $res);

        $exp = "raise";
        $res = $player->setAndGetCleveMovePre(60, 2);
        $this->assertEquals($exp, $res);

        $exp = "fold";
        $res = $player->setAndGetCleveMovePre(28, 3);
        $this->assertEquals($exp, $res);

        $exp = "call";
        $res = $player->setAndGetCleveMovePre(60, 3);
        $this->assertEquals($exp, $res);

        $exp = "raise";
        $res = $player->setAndGetCleveMovePre(100, 3);
        $this->assertEquals($exp, $res);
    }

    /**
     * Verifies that risk level method returns correct integer.
     */
    public function testCleveRiskLevel() : void
    {
        $cleve = new ComputerCleve("Cleve", 20);
        $player = new TexasPlayer("Martin", 20, 20);

        $exp = 30;
        $res = $cleve->setCleveRiskLevel($player, "pre", 40, 2);
        $this->assertEquals($exp, $res);

        $exp = 70;
        $res = $cleve->setCleveRiskLevel($player, "post", 40, 2);
        $this->assertEquals($exp, $res);
    }
}