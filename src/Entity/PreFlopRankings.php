<?php

namespace App\Entity;

use App\Repository\PreFlopRankingsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreFlopRankingsRepository::class)]
class PreFlopRankings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cards = null;

    #[ORM\Column(length: 1)]
    private ?string $type = null;

    #[ORM\Column(length: 3)]
    private ?string $rank = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCards(): ?string
    {
        return $this->cards;
    }

    public function setCards(string $cards): self
    {
        $this->cards = $cards;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getRank(): ?string
    {
        return $this->rank;
    }

    public function setRank(string $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
