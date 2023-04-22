<?php

/**
 * Class Game
 */

namespace App\Card;

class Game
{
    /**
     * @var Deck            $deck       Deck of cards.
     * @var Player          $human      Human player.
     * @var Bank            $bank       Bank player.
     * @var Player|Bank     $turn       Whose turn it is.
     * @var Rules           $rules      Rules of the game.
     */

    private Deck $deck;
    private Player $human;
    private Bank $bank;
    private Player|Bank $turn;
    private Rules $rules;

    /**
     * @var array<string, mixed> $standings  Game standings.
     */
    private array $standings = [
        "human" => [
            "bust" => false,
            "stop" => false,
            "highAndLow" => false,
            "points" => 0,
            "cards" => []
        ],
        "bank" => [
            "bust" => false,
            "stop" => false,
            "highAndLow" => false,
            "points" => 0,
            "cards" => []
        ],
        "winner" => "",
        "winner_decided" => "No."
    ];

    /**
     * Class constructor
     *
     * @param Deck    $deck       Deck of cards.
     * @param Player  $human      Human player.
     * @param Bank    $bank       Bank player.
     *
     */
    public function __construct(Deck $deck, Player $human, Bank $bank, Rules $rules)
    {
        $this->deck = $deck;
        $this->human = $human;
        $this->bank = $bank;
        $this->bank->setName("bank");
        $this->rules = $rules;
    }

    /**
     * Sets turn.
     *
     * @param string $turn Whose turn it is.
     *
     * @return void
     */
    public function setTurn($turn): void
    {
        $this->turn = ($turn === "human") ? $this->human : $this->bank;

        $this->startTurn();
    }

    /**
     * Starts turn for whatever player.
     *
     * @return void
     */
    public function startTurn(): void
    {
        $card = $this->deck->drawSingle();

        // error_log(print_r($card, true), 3, 'log.txt');

        $this->addCard($card);
    }

    /**
     * Adds card to player hand.
     *
     * @param array<mixed,string> $card Card to add to hand.
     *
     * @return void
     */
    public function addCard($card): void
    {
        $this->turn->addCardToPlayerHand($card);

        $this->calculatePointsForPlayer();
    }

    /**
     * Calculate player points.
     *
     * @return void
     */
    public function calculatePointsForPlayer(): void
    {
        $this->turn->calculatePlayerPoints();
        $player = $this->turn->getName();
        $playerPoints = $this->turn->getPlayerPoints();

        if (is_array($playerPoints)) {
            $playerPoints = (array) $playerPoints;
            $this->standings[$player] =
            [
                ...$this->standings[$player],
                "highAndLow" => true,
                "low" => $playerPoints["low"],
                "high" => $playerPoints["high"]
            ];

            $this->setPlayerCardInfo();
            return;
        }

        $this->standings[$player] = [
            ...$this->standings[$player],
            "points" => $playerPoints,
            "highAndLow" => false
        ];

        $this->setPlayerCardInfo();
    }

    /**
     * Set player card info.
     *
     * @return void
     */
    public function setPlayerCardInfo(): void
    {
        $cardImages = $this->turn->getPlayerCardImages();
        $cardValues = $this->turn->getPlayerCardValues();
        $player = $this->turn->getName();

        $this->standings[$player] = [
                ...$this->standings[$player],
                "cards" => $cardValues,
                "cardImages" => $cardImages
            ];

        $this->setPlayerBestHand();
    }

    /**
     * Set player best hand.
     *
     * @return void
     */
    public function setPlayerBestHand(): void
    {
        $this->turn->setPlayerDefinitivePoints();

        $this->checkIfBust();
    }

    /**
     * Checks if player hand is bust.
     *
     * @return void
     */
    public function checkIfBust(): void
    {
        $points = $this->turn->getPlayerDefinitivePoints();
        $player = $this->turn->getName();

        if ($this->rules->bust($points)) {
            $this->standings[$player] = [
                    ...$this->standings[$player],
                    "bust" => true
                ];
            $this->decideWinner();
        }

        if ($player === "bank") {
            $this->checkBankOverSeventeen();
        }
    }

    /**
     * Checks if player hand is bust.
     *
     * @return void
     */
    public function checkBankOverSeventeen(): void
    {
        if ($this->bank->checkOverSeventeen()) {
            $points = $this->bank->getPlayerDefinitivePoints();
            $player = $this->bank->getName();

            if ($this->rules->bust($points)) {
                $this->standings[$player] = [
                        ...$this->standings[$player],
                        "bust" => true
                    ];
            }

            $this->decideWinner();
            return;
        }

        $this->setTurn("bank");
    }

    /**
     * Decide game winner.
     *
     * @return void
     */
    public function decideWinner(): void
    {
        $humanPoints = $this->human->getPlayerDefinitivePoints();
        $bankPoints = $this->bank->getPlayerDefinitivePoints();

        $this->standings["human"]["points"] = $humanPoints;
        $this->standings["bank"]["points"] = $bankPoints;
        $this->standings["winner_decided"] = "Yes.";

        if ($this->standings["human"]["bust"]) {
            $this->standings["winner"] = "Bank";
            $this->standings["message"] = "Player went bust.";
            return;
        } elseif ($this->standings["bank"]["bust"]) {
            $this->standings["winner"] = "Player";
            $this->standings["message"] = "Bank went bust.";
            return;
        }

        $winner = $this->rules->decideWinner($humanPoints, $bankPoints);

        $this->standings["winner"] = $winner;
        $this->standings["message"] = "$winner has more points.";

        if ($humanPoints === $bankPoints) {
            $this->standings["message"] = "Draw benefits the Bank.";
        }
    }

    /**
     * Get game standings.
     *
     * @return array<string, mixed> with game standings.
     */
    public function getGameStandings(): array
    {
        return $this->standings;
    }
}
