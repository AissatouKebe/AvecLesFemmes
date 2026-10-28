<?php

namespace App\Service;

use App\Dto\CampagneListeDto;
use App\Entity\Epargne;
use App\Repository\CampagneRepository;

class CampagneService
{
    public function __construct(private readonly CampagneRepository $campagneRepository)
    {
    }

    /**
     * @return CampagneListeDto[]
     */
    public function lister(): array
    {
        $dtos = [];

        foreach ($this->campagneRepository->findBy([], ['dateDebut' => 'DESC']) as $campagne) {
            $groupement = $campagne->getGroupement();
            $exercice = $campagne->getExercice();

            $dtos[] = new CampagneListeDto(
                $campagne->getNom(),
                $campagne instanceof Epargne ? 'Épargne' : 'Tontine',
                $groupement->getId(),
                $groupement->getNom(),
                $campagne->getMontant(),
                $campagne->getDateDebut(),

                $campagne->getDateFin(),
                $exercice->getDateDebut(),
                $exercice->getDateFin(),
            );
        }

        return $dtos;
    }
}