<?php

/**
 * TexasGame class
 * This class is responsible for keeping the game together.
 * It has dependencies towards GameData and GameLogic
 * as well as TexasDeck, HandEvaluator and .
 */

namespace App\Texas;

class TexasGame
{
    /**
     * @var TexasDeck $deck Deck of cards.
     */
    private TexasDeck $deck;

    /**
     * @var array<PlayerInterface> $players Players of the game.
     */
    private array $players;

    /**
     * @var HandEvaluator $handEvaluator Evaluator class for evaluating a poker hand.
     */
    private HandEvaluator $handEvaluator;

    /**
     * @var GameLogic $gameLogic GameLogic class which holds methods for the game logic.
     */
    private GameLogic $gameLogic;

    /**
     * @var GameData $gameData GameData class which holds methods for the game logic.
     */
    private GameData $gameData;

    // /**
    //  * @var MessageRepository $messageRepository MessageRepository class which holds methods for the game logic.
    //  */
    // private MessageRepository $messageRepository;

    /**
     * @var Table $table Table class for keeping track of community cards and pot.
     */
    private Table $table;

    /**
     * Class constructor.
     *
     * @param TexasDeck $deck Object with Deck of cards.
     * @param HandEvaluator $handEvaluator Object that evaluates card hand.
     * @param GameLogic $gameLogic Object that manages game logic.
     * @param GameData $gameData Object that manages game data.
     * @param Table $table Object that manages game table.
     * @param array<PlayerInterface> $players Array of players.
     *
     */
    public function __construct(
        TexasDeck $deck,
        HandEvaluator $handEvaluator,
        GameLogic $gameLogic,
        GameData $gameData,
        Table $table,
        array $players
    ) {
        $this->deck = $deck;
        $this->handEvaluator = $handEvaluator;
        $this->gameLogic = $gameLogic;
        $this->gameData = $gameData;
        $this->table = $table;
        $this->players = $players;
    }

    /**
     * WHAT??
     *
     * @return bool
     */
    public function checkComputerPlayerBalance(): bool
    {
        return false;
    }
}
