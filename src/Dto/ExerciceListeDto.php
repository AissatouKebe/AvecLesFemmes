<?php

namespace App\Dto;

final class ExerciceListeDto
{
    public function __construct(
        public readonly int $groupementId,
        public readonly string $groupementNom,
        public readonly \DateTimeInterface $dateDebut,
        public readonly \DateTimeInterface $dateFin,
        public readonly \DateTimeInterface $dateLimitePret,
        public readonly \DateTimeInterface $dateRetribution,
        public readonly string $statutLabel,
        public readonly string $statutValue,
        public readonly int $nombreCampagnes,
    ) {
    }
}