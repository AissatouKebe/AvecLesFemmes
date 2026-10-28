<?php

namespace App\DataFixtures;

use App\Entity\Exercice;
use App\Entity\Groupement;
use App\Enum\StatutExercice;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ExerciceFixtures extends Fixture implements DependentFixtureInterface
{
    public const EN_COURS_PREFIX = 'exercice-en-cours-';
    public const CLOTURE_PREFIX = 'exercice-cloture-';

    public function getDependencies(): array
    {
        return [GroupementFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 3; $i++) {
            $groupement = $this->getReference(GroupementFixtures::REFERENCE_PREFIX . $i, Groupement::class);

            $enCours = $this->creerExercice(
                $manager, $groupement,
                '2026-01-05', '2026-12-31', '2026-10-31', '2027-01-15',
                StatutExercice::ENCOURS
            );
            $this->addReference(self::EN_COURS_PREFIX . $i, $enCours);

            if ($i === 0) {
                $cloture = $this->creerExercice(
                    $manager, $groupement,
                    '2025-01-06', '2025-12-31', '2025-10-31', '2026-01-15',
                    StatutExercice::CLOTURE
                );
                $this->addReference(self::CLOTURE_PREFIX . $i, $cloture);
            }
        }

        $manager->flush();
    }

    private function creerExercice(
        ObjectManager $manager,
        Groupement $groupement,
        string $debut,
        string $fin,
        string $limitePret,
        string $retribution,
        StatutExercice $statut
    ): Exercice {
        $exercice = (new Exercice())
            ->setGroupement($groupement)
            ->setDateDebut(new \DateTime($debut))
            ->setDateFin(new \DateTime($fin))
            ->setDateLimitePret(new \DateTime($limitePret))
            ->setDateRetribution(new \DateTime($retribution))
            ->setStatut($statut);
        $manager->persist($exercice);

        return $exercice;
    }
}