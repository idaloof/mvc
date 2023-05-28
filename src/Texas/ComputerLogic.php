<?php

/**
 * ComputerLogic class
 * Provides computer players with logic
 */

namespace App\Texas;

use App\Repository\PreFlopRankingsRepository;

class ComputerLogic extends CalculatePoints
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

    /**
     * Checks if human player has raised.
     *
     * @param array<string> $moves Player's round moves.
     *
     * @return bool
     */
    private function hasPlayerRaised(array $moves): bool
    {
        if (in_array("raise", $moves)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if human player has called.
     *
     * @param array<string> $moves Player's round moves.
     *
     * @return bool
     */
    private function hasPlayerCalled(array $moves): bool
    {
        if (in_array("call", $moves)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if human player has checked.
     *
     * @param array<string> $moves Player's round moves.
     *
     * @return bool
     */
    private function hasPlayerChecked(array $moves): bool
    {
        if (in_array("check", $moves)) {
            return true;
        }

        return false;
    }

    /**
     * Adjusts Cleve's risk level for player moves.
     *
     * @param array<string> $moves Player's round moves.
     *
     * @return int Risk adjustment.
     */
    public function adjustRiskPlayerMoves(array $moves): int
    {
        $riskAdjust = 0;

        if ($this->hasPlayerChecked($moves) && $this->hasPlayerRaised($moves)) {
            $riskAdjust -= 30;
        } elseif ($this->hasPlayerChecked($moves) && $this->hasPlayerCalled($moves)) {
            $riskAdjust += 10;
        } elseif ($this->hasPlayerChecked($moves)) {
            $riskAdjust += 30;
        } elseif ($this->hasPlayerCalled($moves)) {
            $riskAdjust += 20;
        } elseif ($this->hasPlayerRaised($moves)) {
            $riskAdjust -= 20;
        }

        return $riskAdjust;
    }

    /**
     * Adjusts Cleve's risk level for blind and pot.
     *
     * @param int $pot Pot size.
     * @param int $blind Size of big blind.
     *
     * @return int Risk adjustment.
     */
    public function adjustRiskPotAndBlind(int $pot, int $blind): int
    {
        if ($blind/$pot <= 0.1) {
            return 30;
        } elseif ($blind/$pot <= 0.3) {
            return 10;
        }

        return 0;
    }

    /**
     * Adjusts Cleve's risk level for best hand (post flop).
     *
     * @param int $points Player's hand points.
     *
     * @return int Risk adjustment.
     */
    public function adjustRiskHandPoints(int $points): int
    {
        if ($points >= 400) {
            return 50;
        } elseif ($points >= 300) {
            return 30;
        }

        return 10;
    }
}
