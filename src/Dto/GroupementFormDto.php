<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class GroupementFormDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Le nom est obligatoire')]
        #[Assert\Length(max: 100, maxMessage: '100 caractères maximum')]
        public readonly string $nom = '',

        #[Assert\NotBlank(message: 'Le téléphone est obligatoire')]
        #[Assert\Regex(pattern: '/^[0-9+ ]{9,20}$/', message: 'Numéro invalide (exemple : 77 123 45 67)')]
        public readonly string $tel = '',

        #[Assert\NotBlank(message: "L'adresse est obligatoire")]
        #[Assert\Length(max: 250, maxMessage: '250 caractères maximum')]
        public readonly string $adresse = '',
    ) {
    }
}