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
}
