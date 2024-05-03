<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $QteC = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Client $Client = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $Produit = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ModePaiement $ModeP = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Facture = null;

    #[ORM\ManyToOne]
    private ?Vendeur $Vendeur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQteC(): ?int
    {
        return $this->QteC;
    }

    public function setQteC(int $QteC): static
    {
        $this->QteC = $QteC;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->DateCommande;
    }

    public function setDateCommande(\DateTimeInterface $DateCommande): static
    {
        $this->DateCommande = $DateCommande;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->Client;
    }

    public function setClient(?Client $Client): static
    {
        $this->Client = $Client;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): static
    {
        $this->Produit = $Produit;

        return $this;
    }

    public function getModeP(): ?ModePaiement
    {
        return $this->ModeP;
    }

    public function setModeP(?ModePaiement $ModeP): static
    {
        $this->ModeP = $ModeP;

        return $this;
    }

    public function isFacture(): ?bool
    {
        return $this->Facture;
    }

    public function setFacture(?bool $Facture): static
    {
        $this->Facture = $Facture;

        return $this;
    }
    public function __toString()
    {
        return $this->DateCommande;
    }

    public function getVendeur(): ?Vendeur
    {
        return $this->Vendeur;
    }

    public function setVendeur(?Vendeur $Vendeur): static
    {
        $this->Vendeur = $Vendeur;

        return $this;
    }
}
