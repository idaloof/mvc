<?php

/**
 * GameData class
 * This class is responsible for managing and keeping
 * track of the game state.
 */

namespace App\Texas;

class GameData
{
    /**
     * @var array<string> $players Players of the game.
     */
    private array $players = [];

    /**
     * @var array<int, array<string>> $playerHands Players' best hands.
     */
    private array $playerHands = [];

    /**
     * @var string $gameStage Current game stage.
     */
    private string $gameStage = "pre-flop";

    /**
     * @var int $initialBuyIn The human player's initial buy-in.
     */
    private int $initialBuyIn;

    /**
     * @var int $currentPot Current pot on the table.
     */
    private int $currentPot;

    /**
     * @var array<string> $communityCards Current cards on the table.
     */
    private array $communityCards;

    /**
     * @var string $roundWinner Player who won latest round.
     */
    private string $roundWinner;

    /**
     * @var array<string> $winnerHand Hand of the player that won the latest round.
     */
    private array $winnerHand;

    /**
     * Gets players.
     *
     * @return array<string> Array of players.
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Sets players.
     *
     * @param array<string> $players Array of players.
     *
     * @return void
     */
    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    /**
     * Gets player hands.
     *
     * @return array<int, array<string>> Array of players' hands.
     */
    public function getPlayerHands(): array
    {
        return $this->playerHands;
    }

    /**
     * Sets players' hands.
     *
     * @param array<int, array<string>> $hands Array of players's hands.
     *
     * @return void
     */
    public function setPlayerHands(array $hands): void
    {
        $this->playerHands = $hands;
    }

    /**
     * Gets current game stage.
     *
     * @return string Current game stage.
     */
    public function getGameStage(): string
    {
        return $this->gameStage;
    }

    /**
     * Sets game stage.
     *
     * @param string $stage Current game stage.
     *
     * @return void
     */
    public function setGameStage(string $stage): void
    {
        $this->gameStage = $stage;
    }

    /**
     * Gets initial buy-in.
     *
     * @return int Initial buy-in.
     */
    public function getInitialBuyIn(): int
    {
        return $this->initialBuyIn;
    }

    /**
     * Sets initial buy-in.
     *
     * @param int $buyIn Initial buy-in.
     *
     * @return void
     */
    public function setInitialBuyIn(int $buyIn): void
    {
        $this->initialBuyIn = $buyIn;
    }

    /**
     * Gets current pot.
     *
     * @return int Current pot.
     */
    public function getPot(): int
    {
        return $this->currentPot;
    }

    /**
     * Sets pot.
     *
     * @param int $pot Current pot.
     *
     * @return void
     */
    public function setPot(int $pot): void
    {
        $this->currentPot = $pot;
    }

    /**
     * Gets community cards.
     *
     * @return array<string> Array of community cards.
     */
    public function getCommunityCards(): array
    {
        return $this->communityCards;
    }

    /**
     * Sets community cards.
     *
     * @param array<string> $cards Current community cards.
     *
     * @return void
     */
    public function setCommunityCards(array $cards): void
    {
        $this->communityCards = $cards;
    }

    /**
     * Gets latest round winner.
     *
     * @return string Name of latest round winner.
     */
    public function getRoundWinner(): string
    {
        return $this->roundWinner;
    }

    /**
     * Sets round winner.
     *
     * @param string $winner Latest round's winner.
     *
     * @return void
     */
    public function setRoundWinner(string $winner): void
    {
        $this->roundWinner = $winner;
    }

    /**
     * Gets round winner's cards.
     *
     * @return array<string> Array of round winner's card.
     */
    public function getRoundWinnerHand(): array
    {
        return $this->winnerHand;
    }

    /**
     * Sets round winner's hand.
     *
     * @param array<string> $cards Latest round winner's hand.
     *
     * @return void
     */
    public function setRoundWinnerHand(array $cards): void
    {
        $this->winnerHand = $cards;
    }
}
