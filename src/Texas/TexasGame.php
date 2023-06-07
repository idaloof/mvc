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
     * @var array<PlayerInterface> $players Players of the game.
     */
    private array $players;

    /**
     * @var HandEvaluator $handEvaluator Evaluator class for evaluating a poker hand.
     */
    private HandEvaluator $handEvaluator;

    /**
     * @var GameLogic $gameLogic GameLogic class which holds methods for the game logic.
     */
    private GameLogic $gameLogic;

    /**
     * @var GameData $gameData GameData class which holds methods for the game logic.
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
     * @param array<PlayerInterface> $players       Array of players.
     *
     */
    public function __construct(
        TexasDeck $deck,
        HandEvaluator $handEvaluator,
        GameLogic $gameLogic,
        GameData $gameData,
        Queue $queue,
        Table $table,
        array $players
    ) {
        $this->deck = $deck;
        $this->handEvaluator = $handEvaluator;
        $this->gameLogic = $gameLogic;
        $this->gameData = $gameData;
        $this->queue = $queue;
        $this->table = $table;
        $this->players = $players;
    }

    /**
     * Sets queue and player roles before game-start.
     *
     * @return void
     */
    public function setQueueAndRoles(): void
    {
        $this->queue->setRolesBeforeGameStart();
    }

    /**
     * Get blinds from players and increase pot with blind amounts.
     *
     * @return void
     */
    public function takeBlindsAndAddToPot(): void
    {
        $small = $this->table->getSmallBlind();
        $big = $this->table->getBigBlind();

        $this->queue->getSmallBlindPlayer()->addToBets($small);
        $this->queue->getSmallBlindPlayer()->decreaseBuyIn($small);
        $this->queue->getBigBlindPlayer()->addToBets($big);
        $this->queue->getBigBlindPlayer()->decreaseBuyIn($big);

        $toPot = $big + $small;
        $this->table->addMoneyToPot($toPot);
    }

    /**
     * Draws and deals two starting cards to each player.
     *
     * @return void
     */
    public function dealStartingCards(): void
    {
        $players = $this->queue->getQueue();
        foreach ($players as $player) {
            $card1 = $this->deck->drawSingle();
            $card2 = $this->deck->drawSingle();
            $cards = [$card2, $card1];

            if (intval($card2->getCardValue()) < intval($card1->getCardValue())) {
                $cards = [];
                $cards = [$card1, $card2];
            }

            $player->getHand()->setHoleCards($cards);
        }
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
        $players = $this->queue->getQueue();

        $playerBet = $player->getBets();
        // $playerMoves = $player->getPlayerMoves()->getNumberOfRoundMoves();

        $highestBet = $this->gameLogic->getHighestCurrentBet($players);
        // $highestMoves = $this->gameLogic->getHighestNumberOfActions($players);

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
     * @return void
     */
    public function enqueuePlayer(PlayerInterface $player): void
    {
        $this->queue->enqueue($player);
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
     * @return void
     */
    public function addMoneyToPot(int $amount): void
    {
        $this->table->addMoneyToPot($amount);
    }

    /**
     * Gets small blind.
     *
     * @return int Small blind.
     */
    public function getSmallBlind(): int
    {
        return $this->table->getSmallBlind();
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
     * Player call actions.
     *
     * @param int $callAmount Amount to add to bets, remove from buyIn.
     *
     * @return PlayerInterface
     */
    public function playerCalls(int $callAmount): PlayerInterface
    {
        $player = $this->queue->dequeue();

        $player->addToBets($callAmount);
        $player->decreaseBuyIn($callAmount);
        $this->table->addMoneyToPot($callAmount);

        $this->queue->enqueue($player);

        return $player;
    }

    /**
     * Player raise actions.
     *
     * @param int $raiseAmount Amount to add to bets, remove from buyIn.
     *
     * @return PlayerInterface
     */
    public function playerRaises(int $raiseAmount): PlayerInterface
    {
        $player = $this->queue->dequeue();

        $player->addToBets($raiseAmount);
        $player->decreaseBuyIn($raiseAmount);
        $this->table->addMoneyToPot($raiseAmount);

        $this->queue->enqueue($player);

        return $player;
    }

    /**
     * Player check action.
     *
     * @return PlayerInterface
     */
    public function playerChecks(): PlayerInterface
    {
        $player = $this->queue->dequeue();

        $this->queue->enqueue($player);

        return $player;
    }

    /**
     * Player fold actions.
     *
     * @return PlayerInterface
     */
    public function playerFolds(): PlayerInterface
    {
        $player = $this->queue->dequeue();

        $player->clearPlayerBets();
        $player->getHand()->foldHand();
        $player->getPlayerMoves()->setHasFolded();
        $player->getPlayerMoves()->clearRoundMoves();
        $player->getHand()->clearBestHandProperties();

        $this->queue->enqueue($player);

        return $player;
    }

    /**
     * Resets game property properties before next stage.
     *
     * @return void
     */
    public function resetForNextStage(): void
    {
        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            $player->clearPlayerBets();
            $player->getPlayerMoves()->clearRoundMoves();
        }

        $this->queue->shiftPlayersBeforeNextStage();
    }

    /**
     * Resets game property properties before new round.
     *
     * @return array<mixed>
     */
    public function resetForNewRound(): array
    {
        $this->deck = new TexasDeck();
        $this->deck->shuffleDeck();

        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            $player->clearPlayerBets();
            $player->getPlayerMoves()->clearRoundMoves();
            $player->getHand()->foldHand();
            $player->getHand()->clearBestHandProperties();
            if ($player->getPlayerMoves()->hasFolded()) {
                $player->getPlayerMoves()->setHasFolded();
            }
        }

        $winner = $this->gameLogic->getWinner($players);
        $pot = $this->getPot();

        $winner->increaseBuyIn($pot);

        $this->table->clearPot();
        $this->table->clearCommunityCards();

        $this->queue->setQueueBeforeRoundStart();

        $this->takeBlindsAndAddToPot();
        $this->dealStartingCards();

        return [$winner, $pot];
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
     * Finds and sets player's best hand, name and points.
     *
     * @return void
     */
    public function getAndSetBestHands(): void
    {
        $allCards = [];
        $communityCards = $this->table->getCommunityCards();

        $players = $this->queue->getQueue();

        foreach ($players as $player) {
            if (!$player->getPlayerMoves()->hasFolded()) {
                $holeCards = $player->getHand()->getHoleCards();
                $allCards = array_merge($holeCards, $communityCards);
                $combinations = $this->handEvaluator->setAndGetCombinations($allCards);
                // var_dump($combinations);

                $handData = $this->handEvaluator->evaluateManyHands($combinations);
                // var_dump($handData);
                $bestHandPoints = $handData[0][0];
                $bestHandName = $handData[0][1];
                $bestHand = $handData[0][2];

                $player->getHand()->setBestHand($bestHand);
                $player->getHand()->setBestHandName($bestHandName);
                $player->getHand()->setBestHandPoints($bestHandPoints);
            }
        }
    }

    /**
     * Returns community card images
     *
     * @return array<string> Array with card images.
     */
    public function returnCommunity(): array
    {
        return $this->table->getCommunityCardImages();
    }

    /**
     * Get possible moves for ComputerStu and pass it to ComputerLogic method.
     *
     * @param ComputerStu $stu ComputerStu player.
     *
     * @return array<mixed> Move and amount called or raised.
     */
    public function setStuMoveAndReturnIt(ComputerStu $stu): array
    {
        $moves = $this->getPossibleMoves($stu);

        $highestBet = $this->getHighestCurrentBet();
        $pot = $this->getPot();

        $callSize = $highestBet - $stu->getBets();
        $maxRaise = $callSize + $pot;
        $minRaise = $callSize + $this->getBigBlind();

        return $stu->setAndGetMove(
            $stu,
            $moves,
            $callSize,
            $minRaise,
            $maxRaise
        );
    }

    /**
     * Gets pre or post flop.
     *
     * @return string pre or post.
     */
    public function getPrePostFlop(): string
    {
        if (empty($this->table->getCommunityCards())) {
            return "pre";
        }

        return "post";
    }

    /**
     * Sets risk level depending of pre or post flop.
     *
     * @param string $stage
     * @param ComputerCleve $cleve
     *
     * @return int Risk level.
     */
    public function setCleveRiskLevel(string $stage, ComputerCleve $cleve): int
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

        $moves = $human->getPlayerMoves()->getRoundMoves();
        $pot = $this->table->getPot();
        $blind = $this->table->getBigBlind();

        $handPoints = $cleve->getHand()->getBestHandPoints();

        $potRisk = $cleve->adjustRiskPotAndBlind($pot, $blind);
        $moveRisk = $cleve->adjustRiskPlayerMoves($moves);

        $cleve->adjustRiskLevel($potRisk);
        $cleve->adjustRiskLevel($moveRisk);

        if ($stage === "pre") {
            return $cleve->getRiskLevel();
        }

        $pointRisk = $cleve->adjustRiskHandPoints($handPoints);

        $cleve->adjustRiskLevel($pointRisk);

        return $cleve->getRiskLevel();
    }

    /**
     * This method sets game data properties for api.
     */

    /*
        Vad måste hända innan ett objekt av den här klassen initieras?
            1. TexasHand och PlayerMoves måste initieras (om de ska injectas i spelarna)
            2.  Alla spelare initieras efter att spelaren har angett wallet, namn och buy-in.
                - Spelarna används i både Queue och Game-klassen.
            3.  En kortlek måste initieras.
            4.  En HandEvaluator måste initieras med samtliga evaluators (se test).
            5.  Måste en CardCombinator initieras om den extendas av HandEvaluator?
            6.  En ComputerLogic måste initieras med PreFlopRepo.
            7.  En GameLogic måste initieras.
            8.  En GameData måste initieras.
            9.  En Queue måste initieras.
            10. En Table måste initieras.
            11. MessageRepo måste initieras.
        * Vad vill jag att den här klassen ska göra?
        * Tänk på att controllern pratar med denna klass, endast.
        INNAN PRE-FLOP:
            1.  Sätt rollerna och platserna i kön innan spelstart (Queue) KLART
                - Sätt även spelarnas roller i setPlayerRole -> "bb", "sb" eller "d" KLART
            2.  Sätt small och big blind utifrån spelarens buy in, 1 respektive 2 procent. (Table) KLART
            3.  Hämta välkomstmeddelande från messageRepo (hämta hela tiden senaste 5 från databasen). KLART (görs från controllern)
        PRE-FLOP:
            4.  Small och big blind dras från respektive spelares pengar. (TexasPlayer buy-in) KLART
            5.  Hole cards delas ut till varje spelare. (TexasDeck, TexasPlayer->TexasHand) KLART
                - I controllern hämtas spelarnas hole cards som ska visas på sidan. KLART (vet hur det ska gå till i alla fall!)
            6.  Spelaren är först ut att vara dealer, spelaren börjar således första rundan. KLART
            7.  Beräkna hur mycket spelaren får betta -> max pot-limit (även när bara small och big blind ligger på bordet) KLART
                - Beräkna även hur mycket som krävs för call. KLART
            8.  Spelaren tar ett beslut: (GameEvents-klass/objekt? som har metoder för raise, check, fold, call)
                Spelaren måste ha en egen path genom spelflödet??. det är inte endast spelarens moves som sparas.
                - Om spelaren fold:
                    * spelarens hasFolded sätts (Player->PlayerMoves)
                    * lägg till meddelande i messageboard
                - Om spelaren check:
                    * lägg till check i moves (Player->PlayerMoves->addToRoundMoves)
                    * lägg till meddelande i messageboard
                - Om spelaren call:
                    * spelarens buy in sjunker med call-belopp (måste skötas från game-klassen)
                    * lägg till call i moves (Player->PlayerMoves->addToRoundMoves)
                    * lägg till meddelande i messageboard
                - Om spelaren raise:
                    * spelarens buy in sjunker med raise-belopp (måste skötas från game-klassen)
                    * lägg till raise i moves (Player->PlayerMoves->addToRoundMoves)
                    * lägg till meddelande i messageboard
            X.  Hämta och visa messageboard (hämta hela tiden senaste 5 från databasen).
            X.  Beräkna hur mycket ComputerStu får betta -> max pot-limit (även när bara small och big blind ligger på bordet)
                - Beräkna även hur mycket som krävs för call.
            X.  ComputerStu's tur:
                Kolla om ComputerStu har foldat. Player->PlayerMoves->hasFolded
                Kolla om ComputerStu har färre moves än högsta antalet moves. Player->PlayerMoves->getNumberOfRoundMoves
                Om ej foldat och har färre moves:
                Kolla gamestage:
                - Beroende på game stage får ComputerStu olika alternativ.
                    * Pre-flop:
                        - Om Stu inte har högsta betten: -> skapa metod för movesWhenHighestBet tre alternativ 50 50
                            * fold, call och raise
                        - Om Stu har högsta betten: -> skapa metod för movesWhenNotHighestBet två alternativ 50 50
                            * check och raise
            X.  Hämta spelarens bet som ska visas på sidan.
            X.  Kolla om spelrundan är över (GameLogic) via controller.
            X.  Om föregående är nej -> Kolla om spelet är redo att gå vidare till nästa runda (GameLogic) via controller.
            X.
    */
}
