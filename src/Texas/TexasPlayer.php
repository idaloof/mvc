<?php

/**
 * Class TexasPlayer
 * This class is responsible for managing a player's properties.
 * It has dependencies towards the Hand class and the PlayerMoves class.
 */

namespace App\Texas;

class TexasPlayer implements PlayerInterface
{
    /**
     * @var string          $name       Player name.
     * @var int             $wallet     Player's digital wallet.
     * @var int             $buyIn      Player's buy in for a game.
     * @var int             $bets       Player's bets for a betting round.
     * @var TexasHand       $hand       Hand object.
     * @var PlayerMoves     $moves      PlayerMoves object.
     */

    private string $name;
    private int $wallet;
    private int $buyIn;
    private int $bets = 0;
    protected TexasHand $hand;
    protected PlayerMoves $moves;

    /**
     * Class constructor
     *
     * @param string $name Player name.
     *
     */
    public function __construct(string $name, int $initialWallet, int $initialBuyIn)
    {
        $this->name = $name;
        $this->wallet = $initialWallet;
        $this->buyIn = $initialBuyIn;
        $this->hand = new TexasHand();
        $this->moves = new PlayerMoves();
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
    public function increaseWallet(int $money): void
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
    public function decreaseWallet(int $money): void
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
    public function increaseBuyIn(int $money): void
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
    public function decreaseBuyIn(int $money): void
    {
        $this->buyIn -= $money;
    }

    /**
     * Gets bets of player.
     *
     * @return int Amount of money a player has bet in a single betting round (e.g. pre-flop).
     */
    public function getBets(): int
    {
        return $this->bets;
    }

    /**
     * Adds to player bets.
     *
     * @param int $betAmount Bet amount to be added for betting round.
     *
     * @return void
     */
    public function addToBets(int $betAmount): void
    {
        $this->bets += $betAmount;
    }

    /**
     * Clears player's bets.
     *
     * @return void
     */
    public function clearPlayerBets(): void
    {
        $this->bets = 0;
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
     * Gets moves of player.
     *
     * @return PlayerMoves Player moves.
     */
    public function getPlayerMoves(): PlayerMoves
    {
        return $this->moves;
    }
}