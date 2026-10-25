<?php

namespace App\Entity;

use App\Repository\PretRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PretRepository::class)]
class Pret
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column]
    private ?\DateTime $dateFin = null;

    #[ORM\Column]
    private ?float $tauxApplique = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Epargne $epargne = null;

    #[ORM\ManyToOne(inversedBy: 'prets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Membre $emprunteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getTauxApplique(): ?float
    {
        return $this->tauxApplique;
    }

    public function setTauxApplique(float $tauxApplique): static
    {
        $this->tauxApplique = $tauxApplique;

        return $this;
    }

    public function getEpargne(): ?Epargne
    {
        return $this->epargne;
    }

    public function setEpargne(?Epargne $epargne): static
    {
        $this->epargne = $epargne;

        return $this;
    }

    public function getEmprunteur(): ?Membre
    {
        return $this->emprunteur;
    }

    public function setEmprunteur(?Membre $emprunteur): static
    {
        $this->emprunteur = $emprunteur;

        return $this;
    }
}
