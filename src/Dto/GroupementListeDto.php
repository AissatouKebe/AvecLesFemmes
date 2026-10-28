<?php

namespace App\Dto;

final class GroupementListeDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $nom,
        public readonly string $adresse,
        public readonly string $tel,
        public readonly ?string $statutLabel,
        public readonly ?string $statutValue,
        public readonly ?\DateTimeInterface $exerciceDebut,
        public readonly int $nombreExercices,
    ) {
    }
}