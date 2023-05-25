<?php

/**
 * TexasGame class
 * This class is responsible for keeping the game together.
 * It has dependencies towards GameEvents, GameData and GameLogic
 * as well as TexasDeck, HandEvaluator and PlayerInterface.
 */

namespace App\Texas;

class TexasGame
{
    /**
     * @var TexasDeck $deck Deck of cards.
     */
    private TexasDeck $deck;

    /**
     * @var HandEvaluator $handEvaluator Evaluator class for evaluating a poker hand.
     */
    private HandEvaluator $handEvaluator;

    /**
     * @var GameLogic $gameLogic GameLogic class which holds methods for the game logic.
     */
    private GameLogic $gameLogic;

    // /**
    //  * @var GameData $gameData GameData class which holds methods for the game logic.
    //  */
    // private GameData $gameData;

    // /**
    //  * @var GameEvents $gameEvents GameEvents class which holds methods for the game logic.
    //  */
    // private GameEvents $gameEvents;
}
