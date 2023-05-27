<?php

/**
 * CardInterface
 * This class sets methods for card classes to implement.
 */

namespace App\Texas;

interface CardInterface
{
    public function getCardName(): string;

    public function getCardImage(): string;

    public function getCardSuit(): string;

    public function getCardValue(): string;

    public function getCardRank(): string;
}
