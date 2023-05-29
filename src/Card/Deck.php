<?php

/**
 * Class Deck
 */

namespace App\Card;

use Exception;

class Deck
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
        'T' => 'Ten',
        'J' => 'Jack',
        'Q' => 'Queen',
        'K' => 'King',
    ];

    /**
     * @var array<string, string> $suits Card suits
     */
    private array $suits = [
        'S' => 'spades',
        'H' => 'hearts',
        'C' => 'clubs',
        'D' => 'diamonds'
    ];

    /**
     * @var array<string,array<string,string>> $deck Complete deck
     */
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
     * @return array<string,array<string,string>> of cards.
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

    /**
     * Draws first card from deck
     *
     * @return array<string> with card information
     */
    public function drawSingle(): array
    {
        if (empty($this->deck)) {
            return ["No more cards to draw."];
        }

        $drawnCard = array_shift($this->deck);

        return $drawnCard;
    }

    /**
     * Draws many cards from deck
     *
     * @param int $number Number of cards to be drawn
     *
     * @return array<string> with card information
     */
    public function drawMany(int $number): array
    {
        if ($number > $this->getDeckCount()) {
            throw new Exception("You tried to draw too many cards.");
        }

        $manyCards = [];
        for ($i = 1; $i <= $number; $i++) {
            $oneCardInfo = $this->drawSingle();
            $oneCard = $oneCardInfo["image"];
            array_push($manyCards, $oneCard);
        }

        return $manyCards;
    }

    /**
     * Draws many cards for many players from deck
     *
     * @param int $number Number of cards per player
     * @param int $players Number of players
     *
     * @return array<int, array<string>> with card information
     */
    public function drawManyCardsAndPlayers(int $number, int $players): array
    {
        if ($number * $players > $this->getDeckCount()) {
            throw new Exception("You tried to draw too many cards.");
        }

        $manyCards = [];
        for ($i = 1; $i <= $players; $i++) {
            $aPlayer = $this->drawMany($number);
            array_push($manyCards, $aPlayer);
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
