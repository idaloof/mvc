<?php

/**
 * Class Computer Stu
 * This class is responsible for managing a player's properties.
 * It has dependencies towards the Hand class and the PlayerMoves class.
 */

namespace App\Texas;

class ComputerStu implements PlayerInterface
{
    /**
     * @var string          $name       Player name.
     * @var string          $role       Player role.
     * @var int             $buyIn      Player's buy in for a game.
     * @var int             $bets       Player's bets for a betting round.
     * @var TexasHand       $hand       Hand object.
     * @var PlayerMoves     $moves      PlayerMoves object.
     */

    protected string $name;
    protected string $role = "";
    protected int $buyIn;
    protected int $bets = 0;
    protected TexasHand $hand;
    protected PlayerMoves $moves;

    /**
     * Class constructor
     *
     * @param string $name Player name.
     *
     */
    public function __construct(string $name, int $initialBuyIn)
    {
        $this->name = $name;
        $this->buyIn = $initialBuyIn;
        $this->hand = new TexasHand();
        $this->moves = new PlayerMoves();
    }

    /**
     * Gets name of player.
     *
     * @return string name of player.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Gets role of player.
     *
     * @return string role of player.
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * Sets role of player.
     *
     * @param string $role Role of player.
     *
     * @return void
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * Gets buy-in of player.
     *
     * @return int Amount of money in player buy-in.
     */
    public function getBuyIn(): int
    {
        return $this->buyIn;
    }

    /**
     * Increases money in player buy-in.
     *
     * @param int $money Amount of money to increase player buy-in with.
     *
     * @return void
     */
    public function increaseBuyIn(int $money): void
    {
        $this->buyIn += $money;
    }

    /**
     * Decreases money in player buy-in.
     *
     * @param int $money Amount of money to decrease player buy-in with.
     *
     * @return void
     */
    public function decreaseBuyIn(int $money): void
    {
        $this->buyIn -= $money;
    }

    /**
     * Gets bets of player.
     *
     * @return int Amount of money a player has bet in a single betting round (e.g. pre-flop).
     */
    public function getBets(): int
    {
        return $this->bets;
    }

    /**
     * Adds to player bets.
     *
     * @param int $betAmount Bet amount to be added for betting round.
     *
     * @return void
     */
    public function addToBets(int $betAmount): void
    {
        $this->bets += $betAmount;
    }

    /**
     * Clears player's bets.
     *
     * @return void
     */
    public function clearPlayerBets(): void
    {
        $this->bets = 0;
    }

    /**
     * Gets hand of player.
     *
     * @return TexasHand Player hand.
     */
    public function getHand(): TexasHand
    {
        return $this->hand;
    }

    /**
     * Gets moves of player.
     *
     * @return PlayerMoves Player moves.
     */
    public function getPlayerMoves(): PlayerMoves
    {
        return $this->moves;
    }

    /**
     * Gets player data for easier access in controller.
     *
     * @return array<string, mixed> Array of player info.
     */
    public function getPlayerData(): array
    {
        $playerData = [
            'name' => $this->name,
            'role' => $this->role,
            'buy_in' => $this->buyIn,
            'hasFolded' => $this->moves->hasFolded(),
            'bets' => $this->bets,
            'holeCards' => $this->getHand()->getBestHandAsImages(),
        ];

        return $playerData;
    }
}
