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
     * @var PreFlopRankingsRepository $preFlopRankingsRepository 
     */
    private PreFlopRankingsRepository $preFlopRankingsRepository;

    /**
     * Class constructor
     *
     * @param PreFlopRankingsRepository $preFlopRankingsRepository
     *
     */
    public function __construct(PreFlopRankingsRepository $repo)
    {
        $this->preFlopRankingsRepository = $repo;
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
     * Gets the ranking of the player's two starting cards.
     *
     * @param array<Card> $cards The two starting cards of the computer player.
     *
     * @return string Ranking of the starting cards.
     */
    public function getPreFlopRanking(array $cards): string
    {
        $ranks = "";

        foreach ($cards as $card) {
            $ranks .= $card->getCardRank();
        }

        $result = $this->preFlopRankingsRepository->findCardRanking($ranks);

        return $result["rank"];
    }
}
