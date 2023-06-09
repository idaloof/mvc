<?php

/**
 * Interface Player
 * This interface provides player methods for its implementing classes.
 */

namespace App\Texas;

interface PlayerInterface
{
    public function getName(): string;

    public function setRole(string $role): void;

    public function getRole(): string;

    public function getBuyIn(): int;

    public function increaseBuyIn(int $money): void;

    public function decreaseBuyIn(int $money): void;

    public function getBets(): int;

    public function addToBets(int $betAmount): void;

    public function clearPlayerBets(): void;

    public function getHand(): TexasHand;

    public function getPlayerMoves(): PlayerMoves;

    /**
     * @return array<string, mixed>
     */
    public function getPlayerData(): array;
}
