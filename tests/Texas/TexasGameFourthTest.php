<?php

/**
 * Test suite for TexasGame class.
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class TexasGameFourthTest extends TestCase
{
    /**
     * Verifies that method returns array.
     */
    public function testSetNextStage() : void
    {
        $queue = new Queue([
            new TexasPlayer("Martin", 20, 20),
            new TexasPlayer("Stu", 20, 20),
            new TexasPlayer("Cleve", 20, 20)
        ]);

        $deck = $this->getMockBuilder(TexasDeck::class)
            ->disableOriginalConstructor()
            ->getMock();
        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameLogic= $this->getMockBuilder(GameLogic::class)
            ->disableOriginalConstructor()
            ->getMock();
        $gameData = $this->getMockBuilder(GameData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $table = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table
        );

        $game->setQueueAndRoles();

        $res = $game->setNextStage();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns array.
     */
    public function testSetNewRound() : void
    {
        $queue = new Queue([
            new TexasPlayer("Martin", 20, 20),
            new TexasPlayer("Stu", 20, 20),
            new TexasPlayer("Cleve", 20, 20)
        ]);

        $queue->getQueue()[0]->getPlayerMoves()->setHasFolded();

        $deck = $this->getMockBuilder(TexasDeck::class)
            ->disableOriginalConstructor()
            ->getMock();

        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $gameLogic = $this->getMockBuilder(GameLogic::class)
            ->onlyMethods(['getWinner'])
            ->disableOriginalConstructor()
            ->getMock();

        $gameLogic
            ->method('getWinner')
            ->willReturn(new TexasPlayer("Martin", 20, 20));

        $gameData = $this->getMockBuilder(GameData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $table = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table
        );

        $game->setQueueAndRoles();

        $res = $game->setNewRound();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns array.
     */
    public function testSetNewRoundTie() : void
    {
        $queue = new Queue([
            new TexasPlayer("Martin", 20, 20),
            new TexasPlayer("Stu", 20, 20),
            new TexasPlayer("Cleve", 20, 20)
        ]);

        $queue->getQueue()[0]->getPlayerMoves()->setHasFolded();

        $deck = $this->getMockBuilder(TexasDeck::class)
            ->disableOriginalConstructor()
            ->getMock();

        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $gameLogic = $this->getMockBuilder(GameLogic::class)
            ->onlyMethods(['getWinner'])
            ->disableOriginalConstructor()
            ->getMock();

        $gameLogic
            ->method('getWinner')
            ->willReturn(new TexasPlayer("Martin", 20, 20));

        $gameData = $this->getMockBuilder(GameData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $table = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table
        );

        $game->setQueueAndRoles();

        $res = $game->setNewRoundTie();

        $this->assertIsArray($res);
    }

    /**
     * Verifies that method returns array.
     */
    public function testGetSetBestHands() : void
    {
        $card1 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();

        $card1
            ->method('getCardValue')
            ->willReturn(
                "10"
            );

        $card2 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();

        $card2
            ->method('getCardValue')
            ->willReturn(
                "14"
            );

        $queue = new Queue([
            new TexasPlayer("Martin", 20, 20),
            new TexasPlayer("Stu", 20, 20),
            new TexasPlayer("Cleve", 20, 20)
        ]);

        $queue->getQueue()[0]->getPlayerMoves()->setHasFolded();

        $deck = new TexasDeck();

        $handEvaluator = $this->getMockBuilder(HandEvaluator::class)
            ->onlyMethods([
                'setAndGetCombinations',
                'evaluateManyHands'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $handEvaluator
            ->method('setAndGetCombinations')
            ->willReturn(['A', 'K', 'Q', 'J', 'T']);

        $handEvaluator
            ->method('evaluateManyHands')
            ->willReturn([[
                1000.0,
                "One Pair",
                [$card1, $card2, $card1, $card2, $card1],
            ]]);

        $gameLogic = $this->getMockBuilder(GameLogic::class)
            ->onlyMethods(['getWinner'])
            ->disableOriginalConstructor()
            ->getMock();

        $gameLogic
            ->method('getWinner')
            ->willReturn(new TexasPlayer("Martin", 20, 20));

        $gameData = $this->getMockBuilder(GameData::class)
            ->disableOriginalConstructor()
            ->getMock();
        $table = $this->getMockBuilder(Table::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game = new TexasGame(
            $deck,
            $handEvaluator,
            $gameLogic,
            $gameData,
            $queue,
            $table
        );

        $game->setQueueAndRoles();
        $game->dealStartingCards();
        $game->setFlopAndGetImages();

        $res = $game->getAndSetBestHands();

        $this->assertIsString($res);
    }
}
