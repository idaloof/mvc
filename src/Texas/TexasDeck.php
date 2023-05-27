<?php

/**
 * Class TexasDeck
 */

namespace App\Texas;

use Exception;

class TexasDeck
{
    /**
     * @var array<string> $values Card values
     */
    private array $values = [
        'A' => 'Ace',
        '2' => 'Two',
        '3' => 'Three',
        '4' => 'Four',
        '5' => 'Five',
        '6' => 'Six',
        '7' => 'Seven',
        '8' => 'Eight',
        '9' => 'Nine',
        '10' => 'Ten',
        'J' => 'Jack',
        'Q' => 'Queen',
        'K' => 'King',
    ];

    /**
     * @var array<string> $suits Card suits
     */
    private array $suits = [
        'S' => 'spades',
        'H' => 'hearts',
        'C' => 'clubs',
        'D' => 'diamonds'
    ];

    /**
     * @var array<Card> $deck Complete deck
     */
    private array $deck = [];

    /**
     * Constructor to initiate the deck.
     *
     * @param Card $card Card to be added to deck.
     *
     */
    public function __construct()
    {
        foreach ($this->suits as $letter => $string) {
            foreach ($this->values as $short => $full) {
                $name = $full . " of " . $string;
                $image = $short . $letter;
                $suit = $letter;
                $rank = $short;
                $cardInstance = new Card($name, $image, $suit, $rank);
                array_push($this->deck, $cardInstance);
            }
        }
    }

    /**
     * Get the complete deck
     *
     * @return array<Card> of cards.
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * Shuffle deck
     * @param int $seed The seed value for the random number generator
     *
     * @return void
     */
    public function shuffleDeck(int $seed = null): void
    {
        if ($seed !== null) {
            mt_srand($seed);
        }

        shuffle($this->deck);
    }

    /**
     * Draws first card from deck
     *
     * @return Card with card information
     */
    public function drawSingle(): Card
    {
        if (empty($this->deck)) {
            throw new Exception("No cards to draw.");
        }

        $drawnCard = array_shift($this->deck);

        return $drawnCard;
    }

    /**
     * Draws many cards from deck
     *
     * @param int $number Number of cards to be drawn
     *
     * @return array<Card> with card information
     */
    public function drawMany(int $number): array
    {
        $manyCards = [];
        for ($i = 1; $i <= $number; $i++) {
            $oneCard = $this->drawSingle();
            array_push($manyCards, $oneCard);
        }

        return $manyCards;
    }

    /**
     * Gets deck count.
     *
     * @return int with number of cards in deck.
     */
    public function getDeckCount(): int
    {
        return count($this->deck);
    }
}
