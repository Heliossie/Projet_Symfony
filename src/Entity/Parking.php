<?php

namespace App\Entity;

use App\Repository\ParkingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParkingRepository::class)
 */
class Parking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_ext;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $insee;

    /**
     * @ORM\Column(type="float")
     */
    private $xlong;

    /**
     * @ORM\Column(type="float")
     */
    private $ylat;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nb_places;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdExt(): ?string
    {
        return $this->id_ext;
    }

    public function setIdExt(string $id_ext): self
    {
        $this->id_ext = $id_ext;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getInsee(): ?string
    {
        return $this->insee;
    }

    public function setInsee(string $insee): self
    {
        $this->insee = $insee;

        return $this;
    }

    public function getXlong(): ?float
    {
        return $this->xlong;
    }

    public function setXlong(float $xlong): self
    {
        $this->xlong = $xlong;

        return $this;
    }

    public function getYlat(): ?float
    {
        return $this->ylat;
    }

    public function setYlat(float $ylat): self
    {
        $this->ylat = $ylat;

        return $this;
    }

    public function getNbPlaces(): ?int
    {
        return $this->nb_places;
    }

    public function setNbPlaces(?int $nb_places): self
    {
        $this->nb_places = $nb_places;

        return $this;
    }
}
