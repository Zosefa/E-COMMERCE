<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NumeroFacture = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFacture = null;

    #[ORM\OneToMany(targetEntity: Commande::class, mappedBy: 'facture')]
    private Collection $Commande;

    #[ORM\Column(nullable: true)]
    private ?float $MontantTotal = null;

    #[ORM\Column]
    private ?bool $Facturer = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->Commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->NumeroFacture;
    }

    public function setNumeroFacture(string $NumeroFacture): static
    {
        $this->NumeroFacture = $NumeroFacture;

        return $this;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->DateFacture;
    }

    public function setDateFacture(\DateTimeInterface $DateFacture): static
    {
        $this->DateFacture = $DateFacture;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->Commande;
    }

    public function addCommande(Commande $commande): static
    {
        if (!$this->Commande->contains($commande)) {
            $this->Commande->add($commande);
            $commande->setFactures($this);
        }

        return $this; 
    }

    public function removeCommande(Commande $commande): static
    {
        if ($this->Commande->removeElement($commande)) {
            if ($commande->getFactures() === $this) {
                $commande->setFactures(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getDateFacture();
    }

    public function getMontantTotal(): ?float
    {
        return $this->MontantTotal;
    }

    public function setMontantTotal(?float $MontantTotal): static
    {
        $this->MontantTotal = $MontantTotal;

        return $this;
    }

    public function isFacturer(): ?bool
    {
        return $this->Facturer;
    }

    public function setFacturer(bool $Facturer): static
    {
        $this->Facturer = $Facturer;

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
