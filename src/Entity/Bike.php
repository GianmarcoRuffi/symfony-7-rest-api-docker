<?php

namespace App\Entity;

use App\Repository\BikeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Brand name cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Brand name length must be at least {{ limit }} characters long', maxMessage: 'Brand name length must not exceed {{ limit }} characters.')]
    private ?string $Brand = null;


    #[ORM\ManyToOne(targetEntity: Engine::class)]
    #[Assert\NotBlank(message: 'You must indicate an existing serial.')]
    #[ORM\JoinColumn(name: "engine_serial", referencedColumnName: "serial_code")]
    private $engine;


    #[ORM\Column(length: 50, nullable: false)]
    #[Assert\NotBlank(message: 'Color cannot be empty.')]
    #[Assert\Length(min: 2, max: 50, minMessage: 'Color text length must be at least {{ limit }} characters long', maxMessage: 'Color text length must not exceed {{ limit }} characters.')]
    private ?string $Color = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): static
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getEngine(): ?Engine
    {
        return $this->engine;
    }

    public function setEngine(?Engine $engine): self
    {
        $this->engine = $engine;

        return $this;
    }


    public function getColor(): ?string
    {
        return $this->Color;
    }

    public function setColor(?string $Color): static
    {
        $this->Color = $Color;

        return $this;
    }
}
