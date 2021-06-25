<?php

namespace App\Entity;

use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Carpark::class, mappedBy="parking")
     */
    private $carparks;

    /**
     * @ORM\ManyToOne(targetEntity=Operator::class, inversedBy="parkings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $operator;

    /**
     * @ORM\ManyToMany(targetEntity=Pricelist::class, mappedBy="parking_price")
     */
    private $pricelists;

    public function __construct()
    {
        $this->carparks = new ArrayCollection();
        $this->pricelists = new ArrayCollection();
    }

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

    /**
     * @return Collection|Carpark[]
     */
    public function getCarparks(): Collection
    {
        return $this->carparks;
    }

    public function addCarpark(Carpark $carpark): self
    {
        if (!$this->carparks->contains($carpark)) {
            $this->carparks[] = $carpark;
            $carpark->setParking($this);
        }

        return $this;
    }

    public function removeCarpark(Carpark $carpark): self
    {
        if ($this->carparks->removeElement($carpark)) {
            // set the owning side to null (unless already changed)
            if ($carpark->getParking() === $this) {
                $carpark->setParking(null);
            }
        }

        return $this;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function setOperator(?Operator $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * @return Collection|Pricelist[]
     */
    public function getPricelists(): Collection
    {
        return $this->pricelists;
    }

    public function addPricelist(Pricelist $pricelist): self
    {
        if (!$this->pricelists->contains($pricelist)) {
            $this->pricelists[] = $pricelist;
            $pricelist->addParkingPrice($this);
        }

        return $this;
    }

    public function removePricelist(Pricelist $pricelist): self
    {
        if ($this->pricelists->removeElement($pricelist)) {
            $pricelist->removeParkingPrice($this);
        }

        return $this;
    }
}
