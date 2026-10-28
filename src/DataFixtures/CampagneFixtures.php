<?php

namespace App\DataFixtures;

use App\Entity\Epargne;
use App\Entity\Exercice;
use App\Entity\Tontine;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CampagneFixtures extends Fixture implements DependentFixtureInterface
{
    public const TONTINE = 'campagne-tontine';
    public const EPARGNE = 'campagne-epargne';

    public function getDependencies(): array
    {
        return [ExerciceFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $exercice = $this->getReference(ExerciceFixtures::EN_COURS_PREFIX . '0', Exercice::class);
        $groupement = $exercice->getGroupement();

        $tontine = (new Tontine())
            ->setNom('Tontine mensuelle')
            ->setMontant(10000)
            ->setDateDebut(new \DateTime('2026-01-05'))
            ->setDateFin(new \DateTime('2026-12-31'));


        $epargne = (new Epargne())
            ->setNom('Épargne solidaire')
            ->setMontant(2500)
            ->setDateDebut(new \DateTime('2026-01-05'));

        foreach ([self::TONTINE => $tontine, self::EPARGNE => $epargne] as $reference => $campagne) {
            $campagne->setExercice($exercice)->setGroupement($groupement);
            $manager->persist($campagne);
            $this->addReference($reference, $campagne);
        }

        $manager->flush();
    }
}