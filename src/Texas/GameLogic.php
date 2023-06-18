<?php

/**
 * GameLogic class
 * This class is responsible for the game's logic.
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
        $highBet = $this->getHighestCurrentBet($players);
        // $highActions = $this->getHighestNumberOfActions($players);

        if (
            $player->getBets() === $highBet &&
            $player->getPlayerMoves()->getNumberOfRoundMoves() > 0
        ) {
            return true;
        }
        // } elseif ($player->getBuyIn() === 0) {
        //     return true;
        // }

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

    /**
     * Returns the highest number of action moves.
     *
     * @param array<PlayerInterface> $players Players of the game.
     *
     * @return int Highest number of action moves.
     */
    public function getHighestNumberOfActions(array $players): int
    {
        $actions = [];

        foreach ($players as $player) {
            array_push($actions, $player->getPlayerMoves()->getNumberOfRoundMoves());
        }

        return max($actions);
    }

    /**
     * Returns winner.
     *
     * @param array<PlayerInterface> $players Players in the game.
     *
     * @return PlayerInterface Winner.
     */
    public function getWinner(array $players): PlayerInterface
    {
        if ($this->isWinnerByFold($players)) {
            return $this->getWinnerByFold($players);
        }

        return $this->getWinnerByBestHand($players);
    }

    /**
     * Check if winner should be decided because of folding players,
     * rather than a winning hand.
     *
     * @param array<PlayerInterface> $players.
     *
     * @return bool
     */
    public function isWinnerByFold(array $players): bool
    {
        if ($this->getNumberOfFoldedPlayers($players) > 1) {
            return true;
        }

        return false;
    }

    /**
     * Returns winner by others folding.
     *
     * @param array<PlayerInterface> $players Players in the game.
     *
     * @return PlayerInterface Winner.
     */
    public function getWinnerByFold(array $players): PlayerInterface
    {
        /**
         * @var PlayerInterface $winner
         */
        $winner = null;

        foreach ($players as $player) {
            if ($player->getPlayerMoves()->hasFolded()) {
                continue;
            }

            $winner = $player;
        }

        return $winner;
    }

    /**
     * Returns winner by best hand.
     *
     * @param array<PlayerInterface> $players Players in the game.
     *
     * @return PlayerInterface Winner.
     */
    public function getWinnerByBestHand(array $players): PlayerInterface
    {
        $count = count($players);

        /**
         * @var PlayerInterface $winner
         */
        $winner = $players[0];

        for ($i = 1; $i < $count; $i++) {
            if ($players[$i]->getHand()->getBestHandPoints() > $winner->getHand()->getBestHandPoints()) {
                $winner = $players[$i];
            }
        }

        return $winner;
    }

    /**
     * Checks if game is tied.
     *
     * @param array<PlayerInterface> $players Players in the game.
     *
     * @return bool
     */
    public function isGameTied(array $players): bool
    {
        $handPoints = [];

        foreach ($players as $player) {
            if ($player->getPlayerMoves()->hasFolded()) {
                continue;
            }

            $handPoints[] = $player->getHand()->getBestHandPoints();
        }

        $uniquePoints = array_unique($handPoints);

        $countUnique = count($uniquePoints);

        if ($countUnique !== 1) {
            return false;
        }

        return true;
    }

    /**
     * Gets multiple winners when game is tied.
     *
     * @param array<PlayerInterface> $players
     *
     * @return array<PlayerInterface>
     */
    public function getTiedWinners(array $players): array
    {
        /**
         * @var array<PlayerInterface> $winners
         */
        $winners = [];

        foreach ($players as $player) {
            if ($player->getPlayerMoves()->hasFolded()) {
                continue;
            }

            $winners[] = $player;
        }

        return $winners;
    }
}
