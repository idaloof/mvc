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
     * @var array<PlayerInterface> $players Players of the game.
     */
    private array $players = [];

    /**
     * @var string $gameStage Current game stage.
     */
    private string $gameStage = "pre-flop";

    /**
     * @var int $currentPot Current pot on the table.
     */
    private int $currentPot;

    /**
     * @var array<Card> $communityCards Current cards on the table.
     */
    private array $communityCards;

    /**
     * @var PlayerInterface $roundWinner Player who won latest round.
     */
    private PlayerInterface $roundWinner;

    /**
     * @var array<Card> $winnerHand Hand of the player that won the latest round.
     */
    private array $winnerHand;

    /**
     * Gets players.
     *
     * @return array<PlayerInterface> Array of players.
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * Sets players.
     *
     * @param array<PlayerInterface> $players Array of players.
     *
     * @return void
     */
    public function setPlayers(array $players): void
    {
        $this->players = $players;
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
     * @return array<Card> Array of community cards.
     */
    public function getCommunityCards(): array
    {
        return $this->communityCards;
    }

    /**
     * Sets community cards.
     *
     * @param array<Card> $cards Current community cards.
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
     * @return PlayerInterface Name of latest round winner.
     */
    public function getRoundWinner(): PlayerInterface
    {
        return $this->roundWinner;
    }

    /**
     * Sets round winner.
     *
     * @param PlayerInterface $winner Latest round's winner.
     *
     * @return void
     */
    public function setRoundWinner(PlayerInterface $winner): void
    {
        $this->roundWinner = $winner;
    }

    /**
     * Gets round winner's cards.
     *
     * @return array<Card> Array of round winner's card.
     */
    public function getRoundWinnerHand(): array
    {
        return $this->winnerHand;
    }

    /**
     * Sets round winner's hand.
     *
     * @param array<Card> $cards Latest round winner's hand.
     *
     * @return void
     */
    public function setRoundWinnerHand(array $cards): void
    {
        $this->winnerHand = $cards;
    }
}
