<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['hebdomadaire' => SeanceHebdomadaire::class, 'mensuelle' => SeanceMensuelle::class])]
abstract class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateSeance = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campagne $campagne = null;

    #[ORM\ManyToOne]
    private ?Membre $beneficiaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateSeance(): ?\DateTime
    {
        return $this->dateSeance;
    }

    public function setDateSeance(\DateTime $dateSeance): static
    {
        $this->dateSeance = $dateSeance;

        return $this;
    }

    public function getCampagne(): ?Campagne
    {
        return $this->campagne;
    }

    public function setCampagne(?Campagne $campagne): static
    {
        $this->campagne = $campagne;

        return $this;
    }

    public function getBeneficiaire(): ?Membre
    {
        return $this->beneficiaire;
    }

    public function setBeneficiaire(?Membre $beneficiaire): static
    {
        $this->beneficiaire = $beneficiaire;

        return $this;
    }
    abstract public function prochaineDate(): \DateTimeImmutable;

}
