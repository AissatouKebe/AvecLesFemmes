<?php

namespace App\Service;

use App\Dto\GroupementFiltreDto;
use App\Dto\GroupementListeDto;
use App\Dto\PageDto;
use App\Entity\Groupement;
use App\Repository\GroupementRepository;

class GroupementService
{
    public function __construct(private readonly GroupementRepository $groupementRepository)
    {
    }

    public function lister(GroupementFiltreDto $filtre): PageDto
    {
        $paginator = $this->groupementRepository->rechercher(
            $filtre->ville,
            $filtre->tel,
            $filtre->page,
            $filtre->parPage,
        );

        // mapping : entités -> DTO de sortie
        $dtos = array_map(
            fn(Groupement $groupement) => $this->versDto($groupement),
            iterator_to_array($paginator),
        );

        return new PageDto($dtos, $filtre->page, $filtre->parPage, count($paginator));
    }

    private function versDto(Groupement $groupement): GroupementListeDto
    {
        $exercice = $groupement->getExerciceEnCours();

        return new GroupementListeDto(
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
}