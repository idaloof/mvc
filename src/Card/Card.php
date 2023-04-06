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
     * @var array  $images   Card images
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
     * Picks one random card from array of images
     *
     * @return string|null Image of drawn card
     */
    public function drawOneCard()
    {
        if (empty($this->images)) {
            return null;
        }

        $randomIndex = array_rand($this->images, 1);

        $drawnCard = $this->images[$randomIndex];

        unset($this->images[$randomIndex]);

        return $drawnCard;
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
