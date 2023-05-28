<?php

/**
 * ComputerLogic class
 * Provides computer players with logic
 */

namespace App\Texas;

use App\Repository\PreFlopRankingsRepository;

class ComputerLogic
{
    /**
     * PreFlopRankingsRepository class which holds methods for requiring data
     * from pre_flop_rankings table of database.
     *
     * @var PreFlopRankingsRepository $flopRepo
     */
    private PreFlopRankingsRepository $flopRepo;

    /**
     * Class constructor
     *
     * @param PreFlopRankingsRepository $repo
     *
     */
    public function __construct(PreFlopRankingsRepository $repo)
    {
        $this->flopRepo = $repo;
    }

    /**
     * Checks if computer player is running out of money.
     *
     * @param PlayerInterface $player Computer player to run check for.
     *
     * @return bool Answers the question "is computer player running out of money?".
     */
    public function isRunningLow(PlayerInterface $player, int $initialBuyIn): bool
    {
        $playersBuyIn = $player->getBuyIn();

        if ($playersBuyIn < 0.3 * $initialBuyIn) {
            return true;
        }

        return false;
    }

    /**
     * Gets starting card ranks as concatenated string.
     *
     * @param array<Card> $cards The two starting cards of the computer player.
     *
     * @return string Starting cards as concatenated string.
     */
    public function getHoleRanks(array $cards): string
    {
        $ranks = "";

        foreach ($cards as $card) {
            $ranks .= $card->getCardRank();
        }

        return $ranks;
    }

    /**
     * Gets starting cards' type as string.
     *
     * @param array<Card> $cards The two starting cards of the computer player.
     *
     * @return string Starting cards' type as string.
     */
    public function getHoleType(array $cards): string
    {
        $type = "o";

        if ($cards[0]->getCardSuit() === $cards[1]->getCardSuit()) {
            $type = "s";
        } elseif ($cards[0]->getCardRank() === $cards[1]->getCardRank()) {
            $type = "p";
        }

        return $type;
    }

    /**
     * Gets starting cards' ranking as int.
     *
     * @param array<Card> $cards The two starting cards of the computer player.
     *
     * @return int Starting cards' ranking as int.
     */
    public function getHoleRanking(array $cards): int
    {
        $type = $this->getHoleType($cards);
        $cardRanks = $this->getHoleRanks($cards);

        $cardCombo = $this->flopRepo->findCardRanking($cardRanks, $type)[0];

        $cardRank = intval($cardCombo->getRank());

        return $cardRank;
    }

    // Cleve måste ha en riskAversion-property som ökar
    // eller sjunker. Riskaversionen ska vara beroende av
    // humanplayer moves, potten i förhållande till blindsen,
    // sin egen insats i rundan i förhållande till potten,
    // vilka kort den har på hand, hur stor chans den har att
    // få stege/färg/två par/triss i nästa stage (flop, turn, river).???
    //
}
