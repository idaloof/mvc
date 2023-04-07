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
     * @var array $images   Card images
     */
    private Deck $deck;
    private array $images;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->deck = new Deck();
        $this->images = $this->deck->getDeckImages();

    }

    /**
     * Get the images.
     *
     * @return array of images.
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Shuffles array of images
     *
     * @return void
     */
    public function shuffleImages()
    {
        shuffle($this->images);
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

        unset($this->images[$image]);

        return $image;
    }

    /**
     * Updates the images array
     *
     * @return void
     */
    public function updateDeck($images)
    {
        $this->images = $images;
    }
}
