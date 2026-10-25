<?php

namespace App\Entity;

use App\Repository\RemboursementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RemboursementRepository::class)]
class Remboursement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column]
    private ?\DateTime $dateEcheance = null;

    #[ORM\ManyToOne(inversedBy: 'remboursements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pret $pret = null;

    #[ORM\Column(nullable: true)]
    private ?float $datePaiement = null;

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

    public function getDateEcheance(): ?\DateTime
    {
        return $this->dateEcheance;
    }

    public function setDateEcheance(\DateTime $dateEcheance): static
    {
        $this->dateEcheance = $dateEcheance;

        return $this;
    }



    public function getPret(): ?Pret
    {
        return $this->pret;
    }

    public function setPret(?Pret $pret): static
    {
        $this->pret = $pret;

        return $this;
    }

    public function getDatePaiement(): ?float
    {
        return $this->datePaiement;
    }

    public function setDatePaiement(?float $datePaiement): static
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }
}
