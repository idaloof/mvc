<?php

/**
 * GameLogic class
 * This class is responsible for checking if round/game is over,
 * if game can move on to next stage and
 * if player is ready, and what
 */

namespace App\Texas;

class GameLogic
{
    /**
     * Returns whether rounds is over or not, depending on amount of folds.
     *
     * @param array<PlayerInterface> $players All players in game.
     *
     * @return bool is round over or not.
     */
    public function isRoundOver(array $players): bool
    {
        $count = 0;

        foreach ($players as $player) {
            if (!$player->getPlayerMoves()->hasFolded()) {
                $count += 1;
            }
        }

        return ($count < 2) ? true : false;
    }

    // /**
    //  * Returns whether game is over or not, depending on amount of money players have left.
    //  *
    //  * @return bool is game over or not.
    //  */
    // public function isGameOver(): bool
    // {
    //     $count = 0;

    //     $players = $this->queue->getQueue();

    //     foreach ($players as $player) {
    //         if ($player->getBuyIn() > 0) {
    //             $count += 1;
    //         }
    //     }

    //     return ($count === 0) ? true : false;
    // }

    /**
     * Returns the current highest bet.
     *
     * @param array<PlayerInterface> $players All players in game.
     *
     * @return int Current highest bet.
     */
    public function getHighestCurrentBet(array $players): int
    {
        $bets = [];

        foreach ($players as $player) {
            array_push($bets, $player->getBets());
        }

        return max($bets);
    }

    /**
     * Checks if player is ready for next round,
     * e.g. not folded and up to speed with bets.
     *
     * @param PlayerInterface $player Player to check.
     * @param array<PlayerInterface> $players All players of game.
     *
     * @return bool if player is ready.
     */
    public function isPlayerReady(PlayerInterface $player, array $players): bool
    {
        $highest = $this->getHighestCurrentBet($players);

        if ($player->getBets() === $highest) {
            return true;
        } elseif ($player->getBuyIn() === 0) {
            return true;
        }

        return false;
    }

    /**
     * Get nr of folded players.
     *
     * @param array<PlayerInterface> $players All players in game.
     *
     * @return int number of folded players.
     */
    public function getNumberOfFoldedPlayers(array $players): int
    {
        $foldCount = 0;

        foreach ($players as $player) {
            if ($player->getPlayerMoves()->hasFolded()) {
                $foldCount += 1;
            }
        }

        return $foldCount;
    }

    /**
     * Returns whether game is ready for next stage.
     * e.g. move on to flop, turn or river.
     *
     * @param array<PlayerInterface> $players All players in game.
     *
     * @return bool is game ready to move on to next stage.
     */
    public function isGameReadyForNextStage(array $players): bool
    {
        $countReady = 0;
        $nrOfPlayers = count($players);

        $foldedPlayers = $this->getNumberOfFoldedPlayers($players);

        $playersLeft = $nrOfPlayers - $foldedPlayers;

        foreach ($players as $player) {
            if ($this->isPlayerReady($player, $players)) {
                $countReady += 1;
            }
        }

        return ($countReady === $playersLeft) ? true : false;
    }
}
