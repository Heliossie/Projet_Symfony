<?php

namespace App\Entity;

use App\Repository\SubscriptionPriceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubscriptionPriceRepository::class)
 */
class SubscriptionPrice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount_sub;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAmountSub(): ?float
    {
        return $this->amount_sub;
    }

    public function setAmountSub(?float $amount_sub): self
    {
        $this->amount_sub = $amount_sub;

        return $this;
    }
}
