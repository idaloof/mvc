<?php

/**
 * Card class
 * This class has properties and methods for a classic card.
 * It is instantiated in the deck class.
 */

namespace App\Texas;

class Card extends CalculatePoints
{
    /**
     * @var string $name    The name of the card.
     * @var string $image   The image name of the card.
     * @var string $suit    The suit of the card.
     * @var string $value   The value of the card.
     * @var string $rank    The rank of the card.
     */

    private string $name;
    private string $image;
    private string $suit;
    private string $value;
    private string $rank;

    /**
     * Class constructor
     *
     * @param string $name  Card name
     * @param string $image Card image name.
     * @param string $suit  Card suit.
     * @param string $rank  Card rank.
     *
     */

    public function __construct(string $name, string $image, string $suit, string $rank)
    {
        $this->name = $name;
        $this->image = $image;
        $this->suit = $suit;
        $this->rank = $rank;

        foreach (self::RANK_POINTS as $k => $v) {
            if ($k === $rank) {
                $this->value = strval($v);
            }
        }
    }

    /**
     * Method that returns card name.
     *
     * @return string Card name.
     */

    public function getCardName()
    {
        return $this->name;
    }

    /**
     * Method that returns card image name.
     *
     * @return string Card image name.
     */

    public function getCardImage()
    {
        return $this->image;
    }

    /**
     * Method that returns card suit.
     *
     * @return string Card suit.
     */

    public function getCardSuit()
    {
        return $this->suit;
    }

    /**
     * Method that returns card value.
     *
     * @return string Card value.
     */

    public function getCardValue()
    {
        return $this->value;
    }

    /**
     * Method that returns card rank.
     *
     * @return string Card rank.
     */

    public function getCardRank()
    {
        return $this->rank;
    }
}
