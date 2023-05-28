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
}
