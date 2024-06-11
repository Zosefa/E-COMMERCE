<?php

namespace App\Entity;

use App\Repository\QuartierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null; 

    #[ORM\Column(length: 255)]
    private ?string $Quartier = null;

    #[ORM\ManyToOne(inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ville $Ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuartier(): ?string
    {
        return $this->Quartier;
    }

    public function setQuartier(string $Quartier): static
    {
        $this->Quartier = $Quartier;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->Ville;
    }

    public function setVille(?Ville $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
