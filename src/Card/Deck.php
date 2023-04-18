<?php

/**
 * Class Deck
 */

namespace App\Card;

class Deck
{
    /**
     * @var array   $values     Card values
     * @var array   $suits      Card suits
     * @var array   $deck       Complete deck
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
    private array $suits = [
        'S' => 'spades',
        'H' => 'hearts',
        'C' => 'clubs',
        'D' => 'diamonds'
    ];
    private array $deck = [];

    /**
     * Constructor to initiate the deck.
     */
    public function __construct()
    {
        foreach ($this->suits as $letter => $suit) {
            foreach ($this->values as $short => $full) {
                $card = [
                    'name' => $full . " of " . $suit,
                    'value' => $short,
                    'suit' => $suit,
                    'image' => $short . $letter
                ];
                array_push($this->deck, $card);
            }
        }
    }

    /**
     * Get the images.
     *
     * @return array<string> of images.
     */
    public function getDeckImages(): array
    {
        $images = [];
        foreach ($this->deck as $card) {
            array_push($images, $card['image']);
        }
        return $images;
    }

    /**
     * Get the complete deck
     *
     * @return array<string> of cards.
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * Shuffle deck
     *
     * @return void
     */
    public function shuffleDeck(): void
    {
        shuffle($this->deck);
    }

    /**
     * Draws one random card from the deck
     *
     * @return array<string> with card information
     */
    public function drawOneCard(): array
    {
        if (empty($this->deck)) {
            return ["No more cards to draw."];
        }

        $randomIndex = array_rand($this->deck, 1);

        $drawnCard = $this->deck[$randomIndex];

        unset($this->deck[$randomIndex]);

        return $drawnCard;
    }
}
