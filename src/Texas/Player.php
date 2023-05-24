<?php

/**
 * Class Player
 * This class is responsible for managing a player's properties.
 * It has dependencies towards the Hand class, the Bet class and the HandEvaluator class.
 */

namespace App\Texas;

class Player
{
    /**
     * @var string          $name       Player name.
     * @var int             $wallet     Player's digital wallet.
     * @var int             $buyIn      Player's buy in for a game.
     * @var TexasHand       $hand       Hand object.
     * @var Bet             $bet        Bet object.
     */

    protected string $name;
    protected int $wallet;
    protected int $buyIn;
    protected TexasHand $hand;
    protected Bet $bet;

    /**
     * Class constructor
     *
     * @param string $name Player name.
     *
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->wallet = 0;
        $this->buyIn = 0;
        $this->hand = new TexasHand();
        $this->bet = new Bet();
    }

    /**
     * Gets name of player.
     *
     * @return string name of player.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets name of player.
     *
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
