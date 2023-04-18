<?php

/**
 * Class Card
 */

namespace App\Card;

use App\Card\Deck;

class Card
{
    /**
     * @var Deck  $deck     Deck of cards
     */
    private Deck $deck;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->deck = new Deck();

    }

    /**
     * Get the images.
     *
     * @return array<string> of images.
     */
    public function getImages()
    {
        $images = $this->deck->getDeckImages();
        return $images;
    }

    /**
     * Shuffles array of images
     *
     * @return void
     */
    public function shuffleImages()
    {
        $this->deck->shuffleDeck();
    }

    /**
     * Counts card in deck
     *
     * @return int number of cards
     */
    public function countCards()
    {
        return count($this->deck->getDeck());
    }

    /**
     * Picks one random card from array of images
     *
     * @return string|null Image of drawn card or null
     */
    public function drawOneCard()
    {
        $drawnCard = $this->deck->drawOneCard();

        $image = $drawnCard['image'];

        return $image;
    }
}
