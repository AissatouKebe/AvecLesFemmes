<?php

namespace App\Service;

use App\Dto\ExerciceListeDto;
use App\Repository\ExerciceRepository;

class ExerciceService
{
    public function __construct(private readonly ExerciceRepository $exerciceRepository)
    {
    }

    /**
     * @return ExerciceListeDto[]
     */
    public function lister(): array
    {
        $dtos = [];

        foreach ($this->exerciceRepository->findBy([], ['dateDebut' => 'DESC']) as $exercice) {
            $groupement = $exercice->getGroupement();

            $dtos[] = new ExerciceListeDto(
                $groupement->getId(),
                $groupement->getNom(),
                $exercice->getDateDebut(),
                $exercice->getDateFin(),
                $exercice->getDateLimitePret(),
                $exercice->getDateRetribution(),
                $exercice->getStatut()->label(),
                $exercice->getStatut()->value,
                $exercice->getCampagnes()->count(),
            );
        }

        return $dtos;
    }
}