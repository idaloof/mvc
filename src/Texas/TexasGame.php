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

    /**
     * @var Queue $queue Queue class which manages queue and player roles.
     */
    private Queue $queue;

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
        Queue $queue,
        Table $table,
        array $players
    ) {
        $this->deck = $deck;
        $this->handEvaluator = $handEvaluator;
        $this->gameLogic = $gameLogic;
        $this->gameData = $gameData;
        $this->queue = $queue;
        $this->table = $table;
        $this->players = $players;
    }

    /*
        Vad måste hända innan ett objekt av den här klassen initieras?
            - Alla spelare initieras efter att spelaren har angett wallet och buy-in.
            - En kortlek måste initieras.
            - En HandEvaluator måste initieras med samtliga evaluators (se test).
            - En GameLogic måste initieras med PreFlopRepo.
            - En GameData måste initieras.
            - En
        * Vad vill jag att den här klassen ska göra?
        * Tänk på att controllern pratar med denna klass, endast.
            1. Sätt rollerna innan spelstart
    */
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
