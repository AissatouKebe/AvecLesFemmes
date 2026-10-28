<?php

namespace App\Entity;

use App\Enum\StatutExercice;
use App\Repository\ExerciceRepository;
use App\Trait\DateTimeTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Exercice
{
    use DateTimeTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column]
    private ?\DateTime $dateFin = null;

    #[ORM\Column]
    private ?\DateTime $dateLimitePret = null;

    #[ORM\Column]
    private ?\DateTime $dateRetribution = null;

    #[ORM\Column(enumType: StatutExercice::class)]
    private ?StatutExercice $statut = null;

    #[ORM\ManyToOne(inversedBy: 'exercices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Groupement $groupement = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateLimitePret(): ?\DateTime
    {
        return $this->dateLimitePret;
    }

    public function setDateLimitePret(\DateTime $dateLimitePret): static
    {
        $this->dateLimitePret = $dateLimitePret;

        return $this;
    }

    public function getDateRetribution(): ?\DateTime
    {
        return $this->dateRetribution;
    }

    public function setDateRetribution(\DateTime $dateRetribution): static
    {
        $this->dateRetribution = $dateRetribution;

        return $this;
    }

    public function getStatut(): ?StatutExercice
    {
        return $this->statut;
    }

    public function setStatut(StatutExercice $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getGroupement(): ?Groupement
    {
        return $this->groupement;
    }

    public function setGroupement(?Groupement $groupement): static
    {
        $this->groupement = $groupement;

        return $this;
    }
}
