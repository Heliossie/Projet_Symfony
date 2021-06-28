<?php

namespace App\Entity;

use App\Repository\PricelistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PricelistRepository::class)
 */
class Pricelist
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity=Parking::class, inversedBy="pricelists")
     */
    private $parking_price;

    public function __construct()
    {
        $this->parking_price = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function setDuration($duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Parking[]
     */
    public function getParkingPrice(): Collection
    {
        return $this->parking_price;
    }

    public function addParkingPrice(Parking $parkingPrice): self
    {
        if (!$this->parking_price->contains($parkingPrice)) {
            $this->parking_price[] = $parkingPrice;
        }

        return $this;
    }

    public function removeParkingPrice(Parking $parkingPrice): self
    {
        $this->parking_price->removeElement($parkingPrice);

        return $this;
    }
}
