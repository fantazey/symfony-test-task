<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarRepository")
 */
class Car
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $producer;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $model;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $vin;

    /**
     * @Constraints\NotNull
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @Constraints\GreaterThanOrEqual(value=0)
     * @Constraints\LessThanOrEqual(value=1000000)
     * @ORM\Column(type="integer")
     */
    private $mileage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducer(): ?string
    {
        return $this->producer;
    }

    public function setProducer(string $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @Constraints\Callback()
     * @param ExecutionContextInterface $context
     * @throws \Exception
     */
    public function validateYear(ExecutionContextInterface $context)
    {
        $now = new \DateTime();
        $maxYear = (int)$now->format("Y");
        if (1900 > $this->getYear() || $this->getYear() > $maxYear) {
            $context
                ->buildViolation("Year is incorrect. Year should be from range 1900-{$maxYear}.")
                ->atPath('year')
                ->addViolation();
        }
    }

    public function getVin(): ?string
    {
        return $this->vin;
    }

    public function setVin(string $vin): self
    {
        $this->vin = $vin;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }
}
