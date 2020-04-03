<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;
/**
 * @ORM\Entity(repositoryClass="App\Repository\AppraisalRepository")
 */
class Appraisal
{
    const
        COMISSION_TYPE = 'comission',
        CONTRACT_TYPE = 'contract';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $average_price;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="integer")
     */
    private $sale_price;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="integer")
     */
    private $repair_price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $buyback_price;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @Constraints\NotNull
     * @ORM\OneToOne(targetEntity="App\Entity\Car")
     */
    private $car;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAveragePrice(): ?int
    {
        return $this->average_price;
    }

    public function setAveragePrice(?int $average_price): self
    {
        $this->average_price = $average_price;

        return $this;
    }

    public function getSalePrice(): ?int
    {
        return $this->sale_price;
    }

    public function setSalePrice(int $sale_price): self
    {
        $this->sale_price = $sale_price;

        return $this;
    }

    public function getRepairPrice(): ?int
    {
        return $this->repair_price;
    }

    public function setRepairPrice(int $repair_price): self
    {
        $this->repair_price = $repair_price;

        return $this;
    }

    public function getBuybackPrice(): ?int
    {
        return $this->buyback_price;
    }

    public function setBuybackPrice(?int $buyback_price): self
    {
        $this->buyback_price = $buyback_price;

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

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }
}
