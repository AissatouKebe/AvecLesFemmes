<?php

namespace App\Service;

use App\Dto\GroupementListeDto;
use App\Repository\GroupementRepository;

class GroupementService
{
    public function __construct(private readonly GroupementRepository $groupementRepository)
    {
    }

    /**
     * @return GroupementListeDto[]
     */
    public function lister(): array
    {
        $dtos = [];

        foreach ($this->groupementRepository->findBy([], ['nom' => 'ASC']) as $groupement) {
            $exercice = $groupement->getExerciceEnCours();

            $dtos[] = new GroupementListeDto(
                $groupement->getId(),
                $groupement->getNom(),
                $groupement->getAdresse(),
                $groupement->getTel(),
                $exercice?->getStatut()->label(),
                $exercice?->getStatut()->value,
                $exercice?->getDateDebut(),
                $groupement->getExercices()->count(),

            );
        }

        return $dtos;
    }
}