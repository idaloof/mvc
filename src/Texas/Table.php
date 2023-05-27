<?php

/**
 * Table class
 * This class is responsible for managing and keeping
 * track of the game table's state.
 */

namespace App\Texas;

class Table
{
    /**
     * @var array<Card> $communityCards Cards on the table.
     */
    private array $communityCards = [];

    /**
     * @var int $pot Size of the pot on the table.
     */
    private int $pot = 0;

    /**
     * Adds card to table's community cards.
     *
     * @param Card $card Card to be added
     *
     * @return void
     */
    public function addToCommunityCards(Card $card): void
    {
        $this->communityCards[] = $card;
    }

    /**
     * Gets community cards.
     *
     * @return array<Card> Community cards.
     */
    public function getCommunityCards(): array
    {
        return $this->communityCards;
    }

    /**
     * Clears community cards.
     *
     * @return void
     */
    public function clearCommunityCards(): void
    {
        $this->communityCards = [];
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
        $this->pot += $amount;
    }

    /**
     * Gets pot.
     *
     * @return int Size of pot.
     */
    public function getPot(): int
    {
        return $this->pot;
    }

    /**
     * Clears pot.
     *
     * @return void
     */
    public function clearPot(): void
    {
        $this->pot = 0;
    }
}
