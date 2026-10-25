<?php

namespace App\Entity;

use App\Repository\SeanceMensuelleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceMensuelleRepository::class)]
class SeanceMensuelle extends Seance
{
    public function prochaineDate(): \DateTimeImmutable
    {
       return \DateTimeImmutable::createFromInterface($this->getDateSeance())->modify('+1 month');
    }
}
