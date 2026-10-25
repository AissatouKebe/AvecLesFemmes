<?php

namespace App\Entity;

use App\Repository\TrancheTauxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrancheTauxRepository::class)]
class TrancheTaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montantMin = null;

    #[ORM\Column]
    private ?float $montantMax = null;

    #[ORM\Column]
    private ?float $taux = null;

    #[ORM\ManyToOne(inversedBy: 'tranchesTaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Epargne $epargne = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantMin(): ?float
    {
        return $this->montantMin;
    }

    public function setMontantMin(float $montantMin): static
    {
        $this->montantMin = $montantMin;

        return $this;
    }

    public function getMontantMax(): ?float
    {
        return $this->montantMax;
    }

    public function setMontantMax(float $montantMax): static
    {
        $this->montantMax = $montantMax;

        return $this;
    }

    public function getTaux(): ?float
    {
        return $this->taux;
    }

    public function setTaux(float $taux): static
    {
        $this->taux = $taux;

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
}
