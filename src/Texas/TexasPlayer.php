<?php

/**
 * Class Player
 * This class is responsible for managing a player's properties.
 * It has dependencies towards the Hand class and the Bet class.
 */

namespace App\Texas;

class TexasPlayer
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
     * Gets wallet of player.
     *
     * @return int Amount of money in player wallet.
     */
    public function getWallet(): int
    {
        return $this->wallet;
    }

    /**
     * Increases money in player wallet.
     *
     * @param int $money Amount of money to increase player wallet with.
     *
     * @return void
     */
    public function increaseWallet(int $money)
    {
        $this->wallet += $money;
    }

    /**
     * Decreases money in player wallet.
     *
     * @param int $money Amount of money to decrease player wallet with.
     *
     * @return void
     */
    public function decreaseWallet(int $money)
    {
        $this->wallet -= $money;
    }

    /**
     * Gets buy-in of player.
     *
     * @return int Amount of money in player buy-in.
     */
    public function getBuyIn(): int
    {
        return $this->buyIn;
    }

    /**
     * Increases money in player buy-in.
     *
     * @param int $money Amount of money to increase player buy-in with.
     *
     * @return void
     */
    public function increaseBuyIn(int $money)
    {
        $this->buyIn += $money;
    }

    /**
     * Decreases money in player buy-in.
     *
     * @param int $money Amount of money to decrease player buy-in with.
     *
     * @return void
     */
    public function decreaseBuyIn(int $money)
    {
        $this->buyIn -= $money;
    }

    /**
     * Gets hand of player.
     *
     * @return TexasHand Player hand.
     */
    public function getHand(): TexasHand
    {
        return $this->hand;
    }

    /**
     * Gets bet of player.
     *
     * @return Bet Player bet.
     */
    public function getBet(): Bet
    {
        return $this->bet;
    }
}
