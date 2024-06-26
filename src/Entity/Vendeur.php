<?php

namespace App\Entity;

use App\Repository\VendeurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VendeurRepository::class)]
class Vendeur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Vendeur = null;

    #[ORM\Column(length: 255)]
    private ?string $Siege = null;

    #[ORM\Column(length: 255)]
    private ?string $TelV = null;

    #[ORM\OneToOne(inversedBy: 'vendeur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $users = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVendeur(): ?string
    {
        return $this->Vendeur;
    }

    public function setVendeur(string $Vendeur): static
    {
        $this->Vendeur = $Vendeur;

        return $this;
    }

    public function getSiege(): ?string
    {
        return $this->Siege;
    }

    public function setSiege(string $Siege): static
    {
        $this->Siege = $Siege;

        return $this;
    }

    public function getTelV(): ?string
    {
        return $this->TelV;
    }

    public function setTelV(string $TelV): static
    {
        $this->TelV = $TelV;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(User $users): static
    {
        $this->users = $users;

        return $this;
    }
    public function __toString()
    {
        return $this->getVendeur();
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
