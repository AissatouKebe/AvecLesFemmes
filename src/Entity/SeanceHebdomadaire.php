<?php

namespace App\Entity;

use App\Repository\SeanceHebdomadaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceHebdomadaireRepository::class)]
class SeanceHebdomadaire extends Seance
{
    public function prochaineDate(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromInterface($this->getDateSeance())->modify('+7 days');
    }
}
