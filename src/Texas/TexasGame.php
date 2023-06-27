<?php

/**
 * TexasGame class
 * This class is responsible for keeping the game together.
 * It has dependencies towards GameData and GameLogic
 * as well as TexasDeck, HandEvaluator and .
 */

namespace App\Texas;

class TexasGame
{
    /**
     * @var TexasDeck $deck Deck of cards.
     */
    private TexasDeck $deck;

    /**
     * @var HandEvaluator $handEvaluator Evaluator class for evaluating a poker hand.
     */
    private HandEvaluator $handEvaluator;

    /**
     * @var GameLogic $gameLogic GameLogic class which holds methods for the game logic.
     */
    private GameLogic $gameLogic;

    /**
     * @var GameData $gameData GameData class which holds methods for
     * setting and getting game data.
     */
    private GameData $gameData;

    /**
     * @var Queue $queue Queue class which manages queue and player roles.
     */
    private Queue $queue;

    /**
     * @var Table $table Table class for keeping track of community cards and pot.
     */
    private Table $table;

    /**
     * Class constructor.
     *
     * @param TexasDeck $deck                       Object with Deck of cards.
     * @param HandEvaluator $handEvaluator          Object that evaluates card hand.
     * @param GameLogic $gameLogic                  Object that manages game logic.
     * @param GameData $gameData                    Object that manages game data.
     * @param Table $table                          Object that manages game table.
     *
     */
    public function __construct(
        TexasDeck $deck,
        HandEvaluator $handEvaluator,
        GameLogic $gameLogic,
        GameData $gameData,
        Queue $queue,
        Table $table
    ) {
        $this->deck = $deck;
        $this->handEvaluator = $handEvaluator;
        $this->gameLogic = $gameLogic;
        $this->gameData = $gameData;
        $this->queue = $queue;
        $this->table = $table;
    }

    /**
     * Sets queue and player roles before game-start.
     *
     * @return array<PlayerInterface>
     */
    public function setQueueAndRoles(): array
    {
        $this->queue->setRolesBeforeGameStart();

        return $this->queue->getQueue();
    }

    /**
     * Get blinds from players and increase pot with blind amounts.
     *
     * @return int
     */
    public function takeBlindsAndAddToPot(): int
    {
        $small = $this->table->getSmallBlind();
        $big = $this->table->getBigBlind();

        $this->queue->getSmallBlindPlayer()->addToBets($small);
        $this->queue->getSmallBlindPlayer()->decreaseBuyIn($small);
        $this->queue->getBigBlindPlayer()->addToBets($big);
        $this->queue->getBigBlindPlayer()->decreaseBuyIn($big);

        $toPot = $big + $small;
        $this->table->addMoneyToPot($toPot);

        return $this->table->getPot();
    }

    /**
     * Draws and deals two starting cards to each player.
     *
     * @return array<PlayerInterface>
     */
    public function dealStartingCards(): array
    {
        $players = $this->queue->getQueue();
        foreach ($players as $player) {
            $cards = $this->deck->drawMany(2);

            if (intval($cards[1]->getCardValue()) > intval($cards[0]->getCardValue())) {
                $cards = [$cards[1], $cards[0]];
            }

            $player->getHand()->setHoleCards($cards);
        }

        return $this->queue->getQueue();
    }

    /**
     * This method returns the player objects of the queue.
     *
     * @return array<PlayerInterface> Players of the queue.
     */
    public function getQueuePlayers(): array
    {
        return $this->queue->getQueue();
    }

    /**
     * Returns number of possible moves for player, 2 or 3.
     *
     * @param PlayerInterface $player Player to return moves for.
     *
     * @return int Number of possible moves.
     */
    public function getPossibleMoves(PlayerInterface $player): int
    {
        $players = $this->getQueuePlayers();

        $playerBet = $player->getBets();

        $highestBet = $this->gameLogic->getHighestCurrentBet($players);

        if ($playerBet === $highestBet) {
            return 2;
        }

        return 3;
    }

    /**
     * Dequeues player and returns it.
     *
     * @return PlayerInterface First player in queue.
     */
    public function dequeuePlayer(): PlayerInterface
    {
        return $this->queue->dequeue();
    }

    /**
     * Enqueues player.
     *
     * @param PlayerInterface $player Player to enqueue.
     *
     * @return PlayerInterface
     */
    public function enqueuePlayer(PlayerInterface $player): PlayerInterface
    {
        $this->queue->enqueue($player);

        return $player;
    }

    /**
     * Gets first player in queue.
     *
     * @return PlayerInterface First player in queue
     */
    public function getFirstPlayer(): PlayerInterface
    {
        return $this->queue->peek();
    }

    /**
     * Checks if round is over.
     *
     * @return bool
     */
    public function isRoundOver(): bool
    {
        $players = $this->queue->getQueue();

        return $this->gameLogic->isRoundOver($players);
    }

    /**
     * Gets highest current bet.
     *
     * @return int Highest current bet.
     */
    public function getHighestCurrentBet(): int
    {
        $players = $this->queue->getQueue();

        return $this->gameLogic->getHighestCurrentBet($players);
    }

    /**
     * Gets pot size.
     *
     * @return int Pot size.
     */
    public function getPot(): int
    {
        return $this->table->getPot();
    }

    /**
     * Adds money to pot.
     *
     * @param int $amount Money to add to pot.
     *
     * @return int
     */
    public function addMoneyToPot(int $amount): int
    {
        $this->table->addMoneyToPot($amount);

        return $this->table->getPot();
    }

    /**
     * Gets big blind.
     *
     * @return int Big blind.
     */
    public function getBigBlind(): int
    {
        return $this->table->getBigBlind();
    }

    /**
     * Ready for next stage.
     *
     * @return bool
     */
    public function isGameReadyForNextStage(): bool
    {
        $players = $this->queue->getQueue();

        return $this->gameLogic->isGameReadyForNextStage($players);
    }

    /**
     * Resets game property properties before next stage.
     *
     * @return array<PlayerInterface>
     */
    public function setNextStage(): array
    {
        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            $player->clearPlayerBets();
            $player->getPlayerMoves()->clearRoundMoves();
        }

        $this->queue->shiftPlayersBeforeNextStage();

        return $players;
    }

    /**
     * Resets game property properties before new round.
     *
     * @return array<mixed>
     */
    public function setNewRound(): array
    {
        $this->deck = new TexasDeck();
        $this->deck->shuffleDeck();

        $players = $this->queue->getQueue();

        $winner = $this->gameLogic->getWinner($players);

        $pot = $this->getPot();

        $winner->increaseBuyIn($pot);

        foreach ($players as $player) {
            $player->clearPlayerBets();
            $player->getPlayerMoves()->clearRoundMoves();
            $player->getHand()->foldHand();
            $player->getHand()->clearBestHandProperties();
            if ($player->getPlayerMoves()->hasFolded()) {
                $player->getPlayerMoves()->setHasFolded();
            }
        }

        $this->table->clearPot();
        $this->table->clearCommunityCards();

        $this->queue->setQueueBeforeRoundStart();

        $this->takeBlindsAndAddToPot();
        $this->dealStartingCards();

        return [$winner, $pot];
    }

    /**
     * Resets game property properties before new round when tie game.
     *
     * @return array<mixed>
     */
    public function setNewRoundTie(): array
    {
        $this->deck = new TexasDeck();
        $this->deck->shuffleDeck();

        $players = $this->queue->getQueue();

        $winners = $this->getWinnersTieGame();
        $pot = $this->getPot();

        $count = count($winners);
        $splitPot = intval($pot/$count);

        foreach ($winners as $winner) {
            $winner->increaseBuyIn($splitPot);
        }

        foreach ($players as $player) {
            $player->clearPlayerBets();
            $player->getPlayerMoves()->clearRoundMoves();
            $player->getHand()->foldHand();
            $player->getHand()->clearBestHandProperties();
            if ($player->getPlayerMoves()->hasFolded()) {
                $player->getPlayerMoves()->setHasFolded();
            }
        }

        $this->table->clearPot();
        $this->table->clearCommunityCards();

        $this->queue->setQueueBeforeRoundStart();

        $this->takeBlindsAndAddToPot();
        $this->dealStartingCards();

        return [$winners, $pot];
    }

    /**
     * Gets winner of the round.
     *
     * @return PlayerInterface Winner of the round.
     */
    public function getWinner(): PlayerInterface
    {
        $players = $this->queue->getQueue();
        $winner = $this->gameLogic->getWinner($players);

        return $winner;
    }

    /**
     * Deal the flop and return the cards.
     *
     * @return array<string> Array of flop card images.
     */
    public function setFlopAndGetImages(): array
    {
        for ($i = 0; $i < 3; $i++) {
            $card = $this->deck->drawSingle();
            $this->table->addToCommunityCards($card);
        }

        return $this->table->getCommunityCardImages();
    }

    /**
     * Deal the turn (or river) and return the cards.
     *
     * @return array<string> Array of community card images.
     */
    public function setTurnAndGetImages(): array
    {
        $card = $this->deck->drawSingle();
        $this->table->addToCommunityCards($card);

        return $this->table->getCommunityCardImages();
    }

    /**
     * Gets if winner is by fold.
     *
     * @return bool
     */
    public function isWinnerByFold(): bool
    {
        $players = $this->queue->getQueue();

        return $this->gameLogic->isWinnerByFold($players);
    }

    /**
     * Finds and sets player's best hand, name and points.
     *
     * @return string
     */
    public function getAndSetBestHands(): string
    {
        $communityCards = $this->getCommunityCards();

        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            if (!$player->getPlayerMoves()->hasFolded()) {
                $holeCards = $player->getHand()->getHoleCards();
                $allCards = array_merge($holeCards, $communityCards);
                $combinations = $this->handEvaluator->setAndGetCombinations($allCards);

                $handData = $this->handEvaluator->evaluateManyHands($combinations);

                // if ($player->getName() === "m8") {
                //     error_log(print_r($handData, true), 3, 'log.txt');
                // }

                // var_dump($handData);

                $bestHandPoints = $handData[0][0];
                $bestHandName = $handData[0][1];
                $bestHand = $handData[0][2];

                $player->getHand()->setBestHand($bestHand);
                $player->getHand()->setBestHandName($bestHandName);
                $player->getHand()->setBestHandPoints($bestHandPoints);
            }
        }

        return "ok";
    }

    /**
     * Gets pre or post flop.
     *
     * @return string pre or post.
     */
    public function getPrePostFlop(): string
    {
        if (empty($this->getCommunityCards())) {
            return "pre";
        }

        return "post";
    }

    /**
     * Gets community cards.
     *
     * @return array<Card> Community cards.
     */
    public function getCommunityCards(): array
    {
        return $this->table->getCommunityCards();
    }

    /**
     * Gets human player.
     *
     * @return PlayerInterface Human player.
     */
    public function getHuman(): PlayerInterface
    {
        $players = $this->getQueuePlayers();

        /**
         * @var PlayerInterface $human
         */
        $human = "";

        foreach ($players as $player) {
            if ($player->getName() !== "Stu" && $player->getName() !== "Cleve") {
                /**
                 * @var PlayerInterface $human
                 */
                $human = $player;
            }
        }

        return $human;
    }

    /**
     * Checks if game is tie.
     *
     * @return bool
     */
    public function isGameTied(): bool
    {
        $players = $this->getQueuePlayers();

        return $this->gameLogic->isGameTied($players);
    }

    /**
     * Returns winners when game is tie.
     *
     * @return array<PlayerInterface>
     */
    public function getWinnersTieGame(): array
    {
        $players = $this->getQueuePlayers();

        return $this->gameLogic->getTiedWinners($players);
    }


    /**
     * Sets properties of game data object and returns the object.
     *
     * @return GameData
     */
    public function setGameData(): GameData
    {
        $this->gameData->setPlayers($this->getQueuePlayers());
        $this->gameData->setGameStage(count($this->getCommunityCards()));
        $this->gameData->setPot($this->getPot());
        $this->gameData->setCommunityCards($this->getCommunityCards());

        return $this->gameData;
    }

}
