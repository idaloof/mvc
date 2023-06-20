<?php

/**
 * MoneyHandler trait
 * This class is responsible for adding money to com players buyins
 */

namespace App\Texas;

use Doctrine\Persistence\ManagerRegistry;

trait MoneyHandlerTrait
{
    /**
     * Adds money to com players' buy in if low on money.
     *
     * @param array<PlayerInterface> $players Array of players.
     * @param int $buyIn Initial buy in.
     * @param ManagerRegistry $doctrine
     *
     * @return string
     */
    public function fillComPlayersBuyIn(
        array $players,
        int $buyIn,
        ManagerRegistry $doctrine
    ): string {
        foreach ($players as $player) {
            $playerName = $player->getName();
            if ($playerName === "Stu" || $playerName === "Cleve") {
                if ($player->getBuyIn() < 0.5 * $buyIn) {
                    $moneyToAdd = $buyIn - $player->getBuyIn();
                    $player->increaseBuyIn($moneyToAdd);

                    $message = $playerName . " utökar sitt saldo med $" . $moneyToAdd;

                    $this->/** @scrutinizer ignore-call */
                        addMessage("Texas", $message, $doctrine);
                }
            }
        }

        return "ok";
    }
}
