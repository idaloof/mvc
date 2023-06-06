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

    /**
     * Adjusts Cleve's risk level for hole card ranks.
     *
     * @param int $cardRank
     *
     * @return int Risk adjustment.
     */
    public function adjustRiskCardRank(int $cardRank): int
    {
        if ($cardRank <= 20) {
            return 50;
        } elseif ($cardRank <= 50) {
            return 40;
        } elseif ($cardRank <= 100) {
            return 30;
        }

        return 10;
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

    /**
     * Wrapper for ComputerStu fold method.
     *
     * @param ComputerLogic $object
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     *
     * @return array<mixed> Fold message and empty amount.
     */
    public function wrapperStuFolds(
        ComputerLogic $object,
        PlayerInterface $player,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        return $object->setStuFolds(
            $player,
            $callSize,
            $minRaise,
            $maxRaise
        );
    }

    /**
     * Method for Stu folding.
     *
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Fold message and empty amount.
     */
    public function setStuFolds(
        PlayerInterface $player,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        $player->getPlayerMoves()->setHasFolded();
        $player->getHand()->foldHand();
        $player->clearPlayerBets();
        $player->getPlayerMoves()->addToRoundMoves("fold");

        return ["fold", ""];
    }

    /**
     * Wrapper for ComputerStu check method.
     *
     * @param ComputerLogic $object
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     *
     * @return array<mixed> Check message and empty amount.
     */
    public function wrapperStuChecks(
        ComputerLogic $object,
        PlayerInterface $player,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        return $object->setStuChecks(
            $player,
            $callSize,
            $minRaise,
            $maxRaise
        );
    }

    /**
     * Method for Stu checking.
     *
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Check message and empty amount.
     */
    public function setStuChecks(
        PlayerInterface $player,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        $player->getPlayerMoves()->addToRoundMoves("check");
        return ["check", ""];
    }

    /**
     * Wrapper for ComputerStu call method.
     *
     * @param ComputerLogic $object
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     *
     * @return array<mixed> Call message and amount.
     */
    public function wrapperStuCalls(
        ComputerLogic $object,
        PlayerInterface $player,
        int $callSize,
        ?int $minRaise = null,
        ?int $maxRaise = null
    ): array {
        return $object->setStuCalls(
            $player,
            $callSize,
            $minRaise,
            $maxRaise
        );
    }

    /**
     * Method for Stu calling.
     *
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Call message and amount.
     */
    public function setStuCalls(
        PlayerInterface $player,
        int $callSize,
        ?int $minRaise = null,
        ?int $maxRaise = null
    ): array {
        $player->addToBets($callSize);
        $player->decreaseBuyIn($callSize);

        $player->getPlayerMoves()->addToRoundMoves("call");

        return ["call", $callSize];
    }

    /**
     * Wrapper for ComputerStu raise method.
     *
     * @param ComputerLogic $object
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     *
     * @return array<mixed> Raise message and amount.
     */
    public function wrapperStuRaises(
        ComputerLogic $object,
        PlayerInterface $player,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        return $object->setStuRaises(
            $player,
            $callSize,
            $minRaise,
            $maxRaise
        );
    }

    /**
     * Method for Stu raising.
     *
     * @param PlayerInterface $player
     * @param int $callSize
     * @param int $minRaise
     * @param int $maxRaise
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Raise message and amount.
     */
    public function setStuRaises(
        PlayerInterface $player,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        var_dump($minRaise);
        var_dump($maxRaise);
        $raiseSize = random_int($minRaise, $maxRaise);

        $player->addToBets($raiseSize);
        $player->decreaseBuyIn($raiseSize);

        $player->getPlayerMoves()->addToRoundMoves("raise");

        return ["raise", $raiseSize];
    }

    /**
     * Sets and gets ComputerStu's next move.
     *
     * @param int $moves Number of allowed moves.
     *
     * @return array<mixed> Move and amount if call or raise.
     */
    public function setAndGetStuMove(
        PlayerInterface $stu,
        int $moves,
        int $callSize,
        int $minRaise,
        int $maxRaise
    ): array {
        $methodCalls = [
            'wrapperStuFolds',
            'wrapperStuCalls',
            'wrapperStuRaises'
        ];

        if ($moves === 2) {
            $methodCalls = [
                'wrapperStuChecks',
                'wrapperStuRaises'
            ];
        }

        $randomMethod = $methodCalls[array_rand($methodCalls)];

        return $this->$randomMethod($this, $stu, $callSize, $minRaise, $maxRaise);
    }
}
