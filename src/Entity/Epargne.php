<?php

namespace App\Entity;

use App\Repository\EpargneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EpargneRepository::class)]
class Epargne extends Campagne
{
    /**
     * @var Collection<int, TrancheTaux>
     */
    #[ORM\OneToMany(targetEntity: TrancheTaux::class, mappedBy: 'epargne')]
    private Collection $tranchesTaux;

    /**
     * @var Collection<int, Pret>
     */
    #[ORM\OneToMany(targetEntity: Pret::class, mappedBy: 'epargne')]
    private Collection $prets;

    public function __construct()
    {
        parent::__construct();
        $this->tranchesTaux = new ArrayCollection();
        $this->prets = new ArrayCollection();
    }

    /**
     * @return Collection<int, TrancheTaux>
     */
    public function getTranchesTaux(): Collection
    {
        return $this->tranchesTaux;
    }

    public function addTranchesTaux(TrancheTaux $tranchesTaux): static
    {
        if (!$this->tranchesTaux->contains($tranchesTaux)) {
            $this->tranchesTaux->add($tranchesTaux);
            $tranchesTaux->setEpargne($this);
        }

        return $this;
    }

    public function removeTranchesTaux(TrancheTaux $tranchesTaux): static
    {
        if ($this->tranchesTaux->removeElement($tranchesTaux)) {
            // set the owning side to null (unless already changed)
            if ($tranchesTaux->getEpargne() === $this) {
                $tranchesTaux->setEpargne(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pret>
     */
    public function getPrets(): Collection
    {
        return $this->prets;
    }

    public function addPret(Pret $pret): static
    {
        if (!$this->prets->contains($pret)) {
            $this->prets->add($pret);
            $pret->setEpargne($this);
        }

        return $this;
    }

    public function removePret(Pret $pret): static
    {
        if ($this->prets->removeElement($pret)) {
            // set the owning side to null (unless already changed)
            if ($pret->getEpargne() === $this) {
                $pret->setEpargne(null);
            }
        }

        return $this;
    }
}
