<?php

/**
 * Class Bet
 * This class is responsible for the betting logic and keeping a player's latest bet.
 */

namespace App\Texas;

class Bet
{
    /**
     * @var bool $hasBettedToCall     If player has betted or not to call.
     */
    private bool $hasBettedToCall = false;

    /**
     * @var bool $hasBettedToRaise     If player has betted or not to raise.
     */
    private bool $hasBettedToRaise = false;

    /**
     * @var int $roundBets     Player round bets.
     */
    private int $roundBets = 0;

    /**
     * Adds to player's roundBets.
     *
     * @param int       $betAmount  Amount of money betted.
     * @param string    $playerMove Which move player made when placing bet.
     *
     * @return void
     */
    public function addToRoundBets(int $betAmount, string $playerMove): void
    {
        if ($playerMove === "raise") {
            $this->hasBettedToRaise = true;
            $this->hasBettedToCall = false;
        }

        if ($playerMove === "call") {
            $this->hasBettedToRaise = false;
            $this->hasBettedToCall = true;
        }

        $this->roundBets += $betAmount;
    }

    /**
     * Returns whether player has raised
     *
     * @return bool Whether player has raised or not.
     */
    public function hasRaised(): bool
    {
        return $this->hasBettedToRaise;
    }

    /**
     * Returns whether player has called
     *
     * @return bool Whether player has called or not.
     */
    public function hasCalled(): bool
    {
        return $this->hasBettedToCall;
    }
}
