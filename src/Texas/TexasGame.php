<?php

/**
 * TexasGame class
 * This class is responsible for keeping the game together.
 * It has dependencies towards GameData and GameLogic
 * as well as TexasDeck, HandEvaluator and .
 */

namespace App\Texas;

use App\Repository\MessagesRepository;

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
     * @var MessagesRepository $messageRepo MessageRepository class which holds methods for the game logic.
     */
    private MessagesRepository $messageRepo;

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
     * @param MessagesRepository $messageRepo       Object that manages messages towards database.
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
        MessagesRepository $messageRepo,
        array $players
    ) {
        $this->deck = $deck;
        $this->handEvaluator = $handEvaluator;
        $this->gameLogic = $gameLogic;
        $this->gameData = $gameData;
        $this->queue = $queue;
        $this->table = $table;
        $this->messageRepo = $messageRepo;
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
        foreach ($this->players as $player) {
            $cards = $this->deck->drawMany(2);

            $player->getHand()->setHoleCards($cards);
        }
    }

    /**
     * This method returns the player objects of the game.
     *
     * @return array<PlayerInterface> Players of the game.
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * This method resets the data properties of all objects before next round
     */
    /* A public function that resets:
        - gameData properties (round winner etc)
        - player hole cards
        - player bets
        - table pot
        - and so on..
    */

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
            6.  Spelaren är först ut att vara dealer, spelaren börjar således första rundan.
            7.  Beräkna hur mycket spelaren får betta -> max pot-limit (även när bara small och big blind ligger på bordet)
                - Beräkna även hur mycket som krävs för call.
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
                Kolla om ComputerStu har färre moves än högsta möjliga antalet moves. Player->PlayerMoves->getNumberOfRoundMoves
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
