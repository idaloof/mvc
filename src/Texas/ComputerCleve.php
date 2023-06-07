<?php

/**
 * Class ComputerCleve
 * This class is responsible for managing a player's properties.
 * It has dependencies towards the Hand class and the PlayerMoves class.
 * This computer player is a smarter version of Computer Stu.
 */

namespace App\Texas;

class ComputerCleve extends ComputerStu implements PlayerInterface
{
    /**
     * @var int $riskLevel Level of risk that computer player is willing to take.
     */

    private int $riskLevel = 0;

    /**
     * Class constructor
     *
     * @param string $name Player name.
     * @param int $initialBuyIn Player's initial buy-in.
     *
     */
    public function __construct(string $name, int $initialBuyIn)
    {
        parent::__construct($name, $initialBuyIn);
    }

    /**
     * Gets clever computer's risk aversion.
     *
     * @return int Level of risk.
     */
    public function getRiskLevel(): int
    {
        return $this->riskLevel;
    }

    /**
     * Adjusts risk level.
     *
     * @param int $amount Amount to adjust risk level with.
     *
     * @return void
     */
    public function adjustRiskLevel(int $amount): void
    {
        $this->riskLevel += $amount;
    }

    /**
     * Adjusts risk level.
     *
     * @return void
     */
    public function clearRiskLevel(): void
    {
        $this->riskLevel = 0;
    }

    /**
     * Method for Cleve folding.
     *
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Fold message and empty amount.
     */
    public function setCleveFolds(): array
    {
        $this->getPlayerMoves()->setHasFolded();
        $this->getHand()->foldHand();
        $this->clearPlayerBets();
        $this->getHand()->clearBestHandProperties();
        $this->getPlayerMoves()->addToRoundMoves("fold");

        return ["fold", ""];
    }

    /**
     * Method for Cleve checking.
     *
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Check message and empty amount.
     */
    public function setCleveChecks(): array
    {
        $this->getPlayerMoves()->addToRoundMoves("check");
        return ["check", ""];
    }

    /**
     * Method for Cleve calling.
     *
     * @param int $callSize
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Call message and amount.
     */
    public function setCleveCalls(int $callSize): array
    {
        $this->addToBets($callSize);
        $this->decreaseBuyIn($callSize);

        $this->getPlayerMoves()->addToRoundMoves("call");

        return ["call", $callSize];
    }

    /**
     * Method for Cleve raising.
     *
     * @param int $minRaise
     * @param int $maxRaise
     * @SuppressWarnings(PHPMD)
     *
     * @return array<mixed> Raise message and amount.
     */
    public function setCleveRaises(int $minRaise, int $maxRaise): array
    {
        $raiseSize = random_int($minRaise, $maxRaise);

        $this->addToBets($raiseSize);
        $this->decreaseBuyIn($raiseSize);

        $this->getPlayerMoves()->addToRoundMoves("raise");

        return ["raise", $raiseSize];
    }

    /**
     * Get possible moves for ComputerCleve and pass it to ComputerLogic method.
     *
     * @param string $move
     * @param int $highestBet
     * @param int $pot
     * @param int $bigBlind
     *
     * @return array<mixed> Move and amount called or raised.
     */
    public function setCleveMoveAndReturnData(
        string $move,
        int $highestBet,
        int $pot,
        int $bigBlind
    ): array {
        $callSize = $highestBet - $this->getBets();
        $maxRaise = $callSize + $pot;
        $minRaise = $callSize + $bigBlind;

        $moveData = [];

        switch ($move) {
            case 'fold':
                $moveData = $this->setCleveFolds();
                break;
            case 'check':
                $moveData = $this->setCleveChecks();
                break;
            case 'call':
                $moveData = $this->setCleveCalls($callSize);
                break;
            default:
                $moveData = $this->setCleveRaises($minRaise, $maxRaise);
                break;
        }

        return $moveData;
    }

    /**
     * Set move and perform move for Computer Cleve post flop.
     *
     * @param int $riskLevel
     * @param int $moves
     *
     * @return string Move to make.
     */
    public function setAndGetCleveMovePost(int $riskLevel, int $moves): string
    {
        $move = "";

        if ($moves === 2) {
            switch (true) {
                case $riskLevel < 60:
                    $move = "check";
                    break;
                default:
                    $move = "raise";
                    break;
            }
            return $move;
        }

        switch (true) {
            case $riskLevel < 40:
                $move = "fold";
                break;
            case $riskLevel < 110:
                $move = "call";
                break;
            default:
                $move = "raise";
                break;
        }

        return $move;
    }

    /**
     * Set move and perform move for Computer Cleve pre flop.
     *
     * @param int $riskLevel
     * @param int $moves
     *
     * @return string Move to make.
     */
    public function setAndGetCleveMovePre(int $riskLevel, int $moves): string
    {
        $move = "";

        if ($moves === 2) {
            switch (true) {
                case $riskLevel < 50:
                    $move = "check";
                    break;
                default:
                    $move = "raise";
                    break;
            }
            return $move;
        }

        switch (true) {
            case $riskLevel < 30:
                $move = "fold";
                break;
            case $riskLevel < 70:
                $move = "call";
                break;
            default:
                $move = "raise";
                break;
        }

        return $move;
    }
}
