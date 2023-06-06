<?php

/**
 * Queue class
 * This class is responsible for managing the order of the players.
 */

namespace App\Texas;

use Exception;

class Queue
{
    /**
     * @var array<PlayerInterface> $players Players of the game.
     */
    private array $players;

    /**
     * @var PlayerInterface $smallBlindPlayer Player that has small blind at the moment.
     */
    private PlayerInterface $smallBlindPlayer;

    /**
     * @var PlayerInterface $bigBlindPlayer Player that has big blind at the moment.
     */
    private PlayerInterface $bigBlindPlayer;

    /**
     * @var PlayerInterface $dealerPlayer Player that has the dealer button at the moment.
     */
    private PlayerInterface $dealerPlayer;

    /**
     * Class constructor
     *
     * @param array<PlayerInterface> $players Players of the game.
     *
     */
    public function __construct(array $players)
    {
        $this->players = $players;
    }

    /**
     * Sets the player roles at game start, with three players dealer starts after blinds are posted.
     *
     * @return array<PlayerInterface> Players in queue.
     */
    public function setRolesBeforeGameStart(): array
    {
        $this->dealerPlayer = $this->dequeue();
        $this->smallBlindPlayer = $this->dequeue();
        $this->bigBlindPlayer = $this->dequeue();

        $this->enqueue($this->dealerPlayer);
        $this->enqueue($this->smallBlindPlayer);
        $this->enqueue($this->bigBlindPlayer);

        $this->dealerPlayer->setRole("d");
        $this->smallBlindPlayer->setRole("sb");
        $this->bigBlindPlayer->setRole("bb");

        return $this->players;
    }

    /**
     * Determines which player is dealer, and which players have the blinds.
     *
     * @return void
     */

    public function enqueue(PlayerInterface $player): void
    {
        $this->players[] = $player;
    }

    /**
     * Dequeues player from queue and returns the player.
     *
     * @return PlayerInterface Player that is dequeued
     */
    public function dequeue(): PlayerInterface
    {
        if (empty($this->players)) {
            throw new Exception("Queue is empty.");
        }

        return array_shift($this->players);
    }

    /**
     * Returns first player in queue.
     *
     * @return PlayerInterface Player that is first in queue.
     */
    public function peek(): PlayerInterface
    {
        return $this->players[0];
    }

    /**
     * Returns queue, e.g. array of players.
     *
     * @return array<PlayerInterface> Array of players in queue.
     */
    public function getQueue(): array
    {
        return $this->players;
    }

    /**
     * Determines which player is dealer
     * and which players have the blinds before next round starts.
     *
     * @return array<PlayerInterface> array of players.
     */

    public function setQueueBeforeRoundStart(): array
    {
        $players = $this->getQueue();
        $nrOfPlayers = count($players);

        for ($i = 0; $i < $nrOfPlayers; $i++) {
            $this->dequeue();
        }

        $theDealer = $this->dealerPlayer;

        $this->dealerPlayer = $this->smallBlindPlayer;
        $this->smallBlindPlayer = $this->bigBlindPlayer;
        $this->bigBlindPlayer = $theDealer;

        $this->enqueue($this->dealerPlayer);
        $this->enqueue($this->smallBlindPlayer);
        $this->enqueue($this->bigBlindPlayer);

        $this->dealerPlayer->setRole("d");
        $this->smallBlindPlayer->setRole("sb");
        $this->bigBlindPlayer->setRole("bb");

        return $this->players;
    }

    /**
     * Shifts the players back in correct queue position
     * so that correct player is first to act (smallBlindPlayer).
     *
     * @return array<PlayerInterface> array of players.
     */
    public function shiftPlayersBeforeNextStage(): array
    {
        $players = $this->getQueue();
        $nrOfPlayers = count($players);

        for ($i = 0; $i < $nrOfPlayers; $i++) {
            $this->dequeue();
        }

        $this->enqueue($this->smallBlindPlayer);
        $this->enqueue($this->bigBlindPlayer);
        $this->enqueue($this->dealerPlayer);

        return $this->players;
    }

    /**
     * Returns small blind player.
     *
     * @return PlayerInterface small blind player.
     */
    public function getSmallBlindPlayer(): PlayerInterface
    {
        return $this->smallBlindPlayer;
    }

    /**
     * Returns big blind player.
     *
     * @return PlayerInterface big blind player.
     */
    public function getBigBlindPlayer(): PlayerInterface
    {
        return $this->bigBlindPlayer;
    }
}
