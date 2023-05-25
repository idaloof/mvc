<?php

/**
 * GameLogic class
 * This class is responsible for managing the queue, checking if round/game is over,
 * checking if game can move on to next stage
 * It has dependencies towards the Queue class.
 */

namespace App\Texas;

class GameLogic
{
    /**
     * @var Queue $queue Queue class which holds the players and methods for de- and enqueueing them.
     */
    private Queue $queue;

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
     * @param Queue $queue
     *
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
    }

    /**
     * Returns first player in queue.
     * Needed for the Game container, when setting the playerToAct property.
     *
     * @return PlayerInterface First player in queue
     */
    public function getFirstInQueue(): PlayerInterface
    {
        return $this->queue->peek();
    }

    /**
     * Returns player that is dequeued.
     *
     * @return PlayerInterface Player that is dequeued and needs to be enqueued again.
     */
    public function dequeuePlayer(): PlayerInterface
    {
        return $this->queue->dequeue();
    }

    /**
     * Enqueues player.
     *
     * @param PlayerInterface $player Player to be enqueued.
     *
     * @return void
     */
    public function enqueuePlayer(PlayerInterface $player): void
    {
        $this->queue->enqueue($player);
    }

    /**
     * Determines which player is dealer
     * and which players have the blinds before game starts.
     *
     * @return void
     */

    public function setQueueBeforeGameStart(): void
    {
        $this->dealerPlayer = $this->queue->dequeue();
        $this->smallBlindPlayer = $this->queue->dequeue();
        $this->bigBlindPlayer = $this->queue->dequeue();

        $this->queue->enqueue($this->dealerPlayer);
        $this->queue->enqueue($this->smallBlindPlayer);
        $this->queue->enqueue($this->bigBlindPlayer);
    }

    /**
     * Determines which player is dealer
     * and which players have the blinds before next round starts.
     *
     * @return void
     */

    public function setQueueBeforeRoundStart(): void
    {
        $players = $this->queue->getQueue();
        $nrOfPlayers = count($players);

        for ($i = 0; $i < $nrOfPlayers; $i++) {
            $this->queue->dequeue();
        }

        $theDealer = $this->dealerPlayer;

        $this->dealerPlayer = $this->bigBlindPlayer;
        $this->bigBlindPlayer = $this->smallBlindPlayer;
        $this->smallBlindPlayer = $theDealer;

        $this->queue->enqueue($this->dealerPlayer);
        $this->queue->enqueue($this->smallBlindPlayer);
        $this->queue->enqueue($this->bigBlindPlayer);
    }

    /**
     * Shifts the players back in correct queue position
     * so that correct player is first to act (smallBlindPlayer).
     *
     * @return void
     */
    public function shiftPlayersBeforeCommunityCards(): void
    {
        $players = $this->queue->getQueue();
        $nrOfPlayers = count($players);

        for ($i = 0; $i < $nrOfPlayers; $i++) {
            $this->queue->dequeue();
        }

        $this->queue->enqueue($this->smallBlindPlayer);
        $this->queue->enqueue($this->bigBlindPlayer);
        $this->queue->enqueue($this->dealerPlayer);
    }

    /**
     * Returns whether rounds is over or not, depending on amount of folds.
     *
     * @return bool is round over or not.
     */
    public function isRoundOver(): bool
    {
        $count = 0;

        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            if (!$player->getPlayerMoves()->hasFolded()) {
                $count += 1;
            }
        }

        return ($count < 2) ? true : false;
    }

    /**
     * Returns whether game is over or not, depending on amount of money players have left.
     *
     * @return bool is game over or not.
     */
    public function isGameOver(): bool
    {
        $count = 0;

        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            if ($player->getBuyIn() > 0) {
                $count += 1;
            }
        }

        return ($count === 0) ? true : false;
    }

    /**
     * Returns the current highest bet.
     *
     * @return int Current highest bet.
     */
    public function getHighestCurrentBet(): int
    {
        $players = $this->queue->getQueue();
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
     *
     * @return bool if player is ready.
     */
    public function isPlayerReady(PlayerInterface $player): bool
    {
        $highest = $this->getHighestCurrentBet();

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
     * @return int number of folded players.
     */
    public function getNumberOfFoldedPlayers(): int
    {
        $foldCount = 0;

        $players = $this->queue->getQueue();

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
     * @return bool is game ready to move on to next stage.
     */
    public function isGameReadyForNextStage(): bool
    {
        $countReady = 0;
        $players = $this->queue->getQueue();
        $nrOfPlayers = count($players);

        $foldedPlayers = $this->getNumberOfFoldedPlayers();

        $playersLeft = $nrOfPlayers - $foldedPlayers;

        foreach ($players as $player) {
            if (!$this->isPlayerReady($player)) {
                $countReady += 1;
            }
        }

        return ($countReady === $playersLeft) ? true : false;
    }
}
