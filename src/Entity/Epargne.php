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

    public function __construct()
    {
        parent::__construct();
        $this->tranchesTaux = new ArrayCollection();
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
}
