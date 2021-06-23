<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $subscription;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity=Carpark::class, mappedBy="invoice")
     */
    private $carparks;

    public function __construct()
    {
        $this->carparks = new ArrayCollection();
    }

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

    public function getSubscription(): ?float
    {
        return $this->subscription;
    }

    public function setSubscription(float $subscription): self
    {
        $this->subscription = $subscription;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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
            $carpark->setInvoice($this);
        }

        return $this;
    }

    public function removeCarpark(Carpark $carpark): self
    {
        if ($this->carparks->removeElement($carpark)) {
            // set the owning side to null (unless already changed)
            if ($carpark->getInvoice() === $this) {
                $carpark->setInvoice(null);
            }
        }

        return $this;
    }
}
