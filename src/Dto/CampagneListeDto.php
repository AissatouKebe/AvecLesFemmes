<?php

namespace App\Dto;

final class CampagneListeDto
{
    public function __construct(
        public readonly string $nom,
        public readonly string $type,
        public readonly int $groupementId,
        public readonly string $groupementNom,
        public readonly float $montant,
        public readonly \DateTimeInterface $dateDebut,
        public readonly ?\DateTimeInterface $dateFin,
        public readonly \DateTimeInterface $exerciceDebut,
        public readonly \DateTimeInterface $exerciceFin,
    ) {
    }
}