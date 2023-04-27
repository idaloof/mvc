<?php

/**
 * Class Game
 */

namespace App\Card;

class Game
{
    use ProbabilityTrait;

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
            "cards" => [],
            "cardImages" => [],
            "probability" => 0.0
        ],
        "bank" => [
            "bust" => false,
            "stop" => false,
            "highAndLow" => false,
            "points" => 0,
            "cards" => [],
            "cardImages" => [],
            "overSeventeen" => false
        ],
        "winner" => "",
        "winner_decided" => "No.",
        "message" => ""
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
                "high" => $playerPoints["high"],
                "points" => $playerPoints["low"]
            ];

            $this->setPlayerCardInfo();
            return;
        }

        $this->standings[$player] = [
            ...$this->standings[$player],
            "points" => $playerPoints,
            "highAndLow" => false
        ];

        $this->calculateBustProbability();
    }

    /**
     * Calculates probability for bust.
     *
     * @return void
     */
    public function calculateBustProbability(): void
    {
        $deck = $this->deck->getDeck();
        $points = $this->standings["human"]["points"];
        $probability = $this->calculateProbability($deck, $points);

        $this->standings["human"] = [
                ...$this->standings["human"],
                "probability" => $probability
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
     * Checks if bank hand is over 17 points.
     *
     * @return void
     */
    public function checkBankOverSeventeen(): void
    {
        if ($this->bank->checkOverSeventeen()) {
            $points = $this->bank->getPlayerDefinitivePoints();
            $player = $this->bank->getName();
            $this->standings[$player] = [
                    ...$this->standings[$player],
                    "overSeventeen" => true
                ];

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
            $this->standings["winner"] = "Banken";
            $this->standings["message"] = "Du blev tjock.";
            return;
        } elseif ($this->standings["bank"]["bust"]) {
            $this->standings["winner"] = "Du";
            $this->standings["message"] = "Banken blev tjock.";
            return;
        }

        $winner = $this->rules->decideWinner($humanPoints, $bankPoints);

        $this->standings["winner"] = $winner;
        $this->standings["message"] = "$winner har mer poäng.";

        if ($humanPoints === $bankPoints) {
            $this->standings["message"] = "Lika gynnar banken.";
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

    /**
     * Get state of game.
     *
     * @return array<string, mixed> with game state.
     */
    public function getGameState(): array
    {
        $state = [
            /**
             * Comments contain game class methods
             * that change part of state array
             */
            "turn"              => $this->turn, //setTurn
            "deckCount"         => $this->deck->getDeckCount(), //startTurn
            "humanLowPoints"    => $this->human->getPlayerLowPoints(), // calculatePoints
            "humanHighPoints"   => $this->human->getPlayerHighPoints(), // calculatePoints
            "humanPoints"       => $this->human->getPlayerDefinitivePoints(), // calculatePoints
            "bankLowPoints"     => $this->bank->getPlayerLowPoints(), // calculatePoints
            "bankHighPoints"    => $this->bank->getPlayerHighPoints(), // calculatePoints
            "bankPoints"        => $this->bank->getPlayerDefinitivePoints(), // calculatePoints
            "bustProbability"   => $this->standings["human"]["probability"], //calculateBustProbability
            "humanCards"        => $this->standings["human"]["cards"], //setPlayerCardInfo
            "humanCardImages"   => $this->standings["human"]["cardImages"], //setPlayerCardInfo
            "bankCards"         => $this->standings["bank"]["cards"], //setPlayerCardInfo
            "bankCardImages"    => $this->standings["bank"]["cardImages"], //setPlayerCardInfo
            "humanBestHand"     => $this->human->getPlayerDefinitivePoints(), // setPlayerBestHand
            "bankBestHand"      => $this->bank->getPlayerDefinitivePoints(), // setPlayerBestHand
            "humanBust"         => $this->standings["human"]["bust"], //checkIfBust
            "bankBust"          => $this->standings["bank"]["bust"], //checkIfBust
            "bankOverSeventeen" => $this->standings["bank"]["overSeventeen"], //checkBankOverSeventeen
            "winnerDecided"     => $this->standings["winner_decided"], //decideWinner
            "winner"            => $this->standings["winner"], //decideWinner
            "message"           => $this->standings["message"], //decideWinner
        ];

        return $state;
    }
}
