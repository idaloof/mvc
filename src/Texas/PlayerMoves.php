<?php

/**
 * Class PlayerMoves
 * This class is responsible for keeping data about the player's round moves.
 */

namespace App\Texas;

class PlayerMoves
{
    /**
     * @var array<string> $roundMoves   Array of player's round moves (not fold).
     */
    private array $roundMoves = [];

    /**
     * @var bool $hasFolded             If player has folded.
     */
    private bool $hasFolded = false;


    /**
     * Returns whether player has called
     *
     * @param string $move Player's latest move, check, call, raise, fold.
     *
     * @return void
     */
    public function addToRoundMoves(string $move): void
    {
        array_push($this->roundMoves, $move);
    }

    /**
     * Returns player's round moves.
     *
     * @return array<string> Player's round moves.
     */
    public function getRoundMoves(): array
    {
        return $this->roundMoves;
    }

    /**
     * Returns number of round moves.
     *
     * @return int Number of round moves.
     */
    public function getNumberOfRoundMoves(): int
    {
        return count($this->roundMoves);
    }

    /**
     * Clears player's round moves.
     *
     * @return void
     */
    public function clearRoundMoves(): void
    {
        $this->roundMoves = [];
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
