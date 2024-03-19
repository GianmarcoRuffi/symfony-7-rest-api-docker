<?php

namespace App\Entity;

use App\Repository\EngineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: EngineRepository::class)]
#[ORM\Table(name: "engine")]
#[UniqueEntity(fields: ["SerialCode"], message: 'An engine already exists with this serial code.')]

class Engine
{

    #[ORM\Id]
    #[ORM\Column(name: "serial_code", length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Serial Code is mandatory.')]
    #[Assert\Length(min: 5, max: 255, minMessage: 'Serial Code length must be at least {{ limit }} characters long', maxMessage: 'Serial Code length must not exceed {{ limit }} characters.')]
    private ?string $SerialCode = null;

    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Name cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Name length must be at least {{ limit }} characters long', maxMessage: 'Name length must not exceed {{ limit }} characters.')]
    private ?string $Name = null;

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank(message: 'Horsepower cannot be empty.')]
    #[Assert\Type(type: 'integer', message: 'Horsepower must be a number.')]
    #[Assert\Positive(message: 'Horsepower cannot be negative.')]
    private ?int $Horsepower = null;

    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Manufacturer cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Manufacturer name length must be at least {{ limit }} characters long', maxMessage: 'Manufacturer name length must not exceed {{ limit }} characters.')]
    private ?string $Manufacturer = null;

    public function getSerialCode(): ?string
    {
        return $this->SerialCode;
    }

    public function setSerialCode(string $SerialCode): static
    {
        $this->SerialCode = $SerialCode;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;
        return $this;
    }

    public function getHorsepower(): ?int
    {
        return $this->Horsepower;
    }

    public function setHorsepower(int $Horsepower): static
    {
        $this->Horsepower = $Horsepower;
        return $this;
    }

    public function getManufacturer(): ?string
    {
        return $this->Manufacturer;
    }

    public function setManufacturer(string $Manufacturer): static
    {
        $this->Manufacturer = $Manufacturer;
        return $this;
    }
}
