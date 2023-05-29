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

    // /**
    //  * @var MessageRepository $messageRepository MessageRepository class which holds methods for the game logic.
    //  */
    // private MessageRepository $messageRepository;

    /**
     * @var Table $table Table class for keeping track of community cards and pot.
     */
    private Table $table;

    /**
     * Class constructor.
     *
     * @param TexasDeck $deck Object with Deck of cards.
     * @param HandEvaluator $handEvaluator Object that evaluates card hand.
     * @param GameLogic $gameLogic Object that manages game logic.
     * @param GameData $gameData Object that manages game data.
     * @param Table $table Object that manages game table.
     * @param array<PlayerInterface> $players Array of players.
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
            1.  Sätt rollerna och platserna i kön innan spelstart (Queue)
                - Sätt även spelarnas roller i setPlayerRole -> "bb", "sb" eller "d"
            2.  Sätt small och big blind utifrån spelarens buy in, 1 respektive 2 procent. (GameData)
            3.  Hämta välkomstmeddelande från messageRepo (hämta hela tiden senaste 5 från databasen).
        PRE-FLOP:
            4.  Small och big blind dras från respektive spelares pengar. (TexasPlayer buy-in)
            5.  Hole cards delas ut till varje spelare. (TexasDeck, TexasPlayer->TexasHand)
                - I controllern hämtas spelarnas hole cards som ska visas på sidan.
            6.  Spelaren är först ut att vara dealer, spelaren börjar således första rundan.
            7.  Beräkna hur mycket spelaren får betta -> max pot-limit (även när bara small och big blind ligger på bordet)
                * Beräkna även hur mycket som krävs för call.
            8.  Spelaren tar ett beslut: (GameEvents-klass/objekt? som har metoder för raise, check, fold, call)
                Spelaren måste ha en egen path genom spellogiken, endast spelarens moves som sparas.
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
            X.  ComputerStu's tur:
                Kolla om ComputerStu har foldat. Player->PlayerMoves->hasFolded
                Kolla om ComputerStu har färre moves än högsta möjliga antalet moves. Player->PlayerMoves->getNumberOfRoundMoves
                Om ej foldat och har färre moves:
                Kolla gamestage:
                - Beroende på game stage det är får ComputerStu olika alternativ.
                    * Pre-flop:
                        - Om Stu inte har högsta betten: -> skapa metod för movesWhenHighestBet tre alternativ 50 50
                            * fold, call och raise
                        - Om Stu har högsta betten: -> skapa metod för movesWhenNotHighestBet två alternativ 50 50
                            * check och raise
            X.  Hämta spelarnas bet som ska visas på sidan.
            X.  Kolla om spelrundan är över (GameLogic) via controller.
            X.  Om 9:an är nej -> Kolla om spelet är redo att gå vidare till nästa runda (GameLogic) via controller.
            X.
    */

    /**
     * WHAT??
     *
     * @return bool
     */
    public function checkComputerPlayerBalance(): bool
    {
        return false;
    }
}
