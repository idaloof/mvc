<?php

/**
 * Class ComputerStu
 * This class is responsible for managing the stupid computer player's properties and methods.
 * It has dependencies towards the Hand class and the Bet class.
 */

namespace App\Texas;

class ComputerStu implements PlayerInterface
{
    /**
     * @var string          $name       Player name.
     * @var int             $buyIn      Player's buy in for a game.
     * @var bool            $hasFolded  Whether player has folded or not.
     * @var TexasHand       $hand       Hand object.
     * @var Bet             $bet        Bet object.
     */

    private string $name;
    private int $buyIn;
    private bool $hasFolded;
    protected TexasHand $hand;
    protected Bet $bet;

    /**
     * Class constructor
     *
     * @param string $name Player name.
     *
     */
    public function __construct(string $name, int $initialBuyIn)
    {
        $this->name = $name;
        $this->buyIn = $initialBuyIn;
        $this->hasFolded = false;
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

    /**
     * Sets property hasFolded.
     *
     * @return void
     */
    public function setHasFolded(): void
    {
        $this->hasFolded = ($this->hasFolded)
            ? false : true;
    }

    /**
     * Gets property hasFolded.
     *
     * @return bool If player has folded or not.
     */
    public function hasFolded(): bool
    {
        return $this->hasFolded;
    }
}
