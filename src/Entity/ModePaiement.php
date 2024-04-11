<?php

namespace App\Entity;

use App\Repository\ModePaiementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModePaiementRepository::class)]
class ModePaiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $CodeMP = null;

    #[ORM\Column(length: 255)]
    private ?string $ModeP = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeMP(): ?string
    {
        return $this->CodeMP;
    }

    public function setCodeMP(string $CodeMP): static
    {
        $this->CodeMP = $CodeMP;

        return $this;
    }

    public function getModeP(): ?string
    {
        return $this->ModeP;
    }

    public function setModeP(string $ModeP): static
    {
        $this->ModeP = $ModeP;

        return $this;
    }
}
