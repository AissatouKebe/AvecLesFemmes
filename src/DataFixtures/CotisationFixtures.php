<?php

namespace App\DataFixtures;

use App\Entity\Cotisation;
use App\Entity\ModeCotisation;
use App\Entity\Seance;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies(): array
    {
        return [ModeCotisationFixtures::class, SeanceFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $config = [
            [CampagneFixtures::TONTINE, SeanceFixtures::TONTINE_PREFIX, 10000, [12000, 10000, 15000]],
            [CampagneFixtures::EPARGNE, SeanceFixtures::EPARGNE_PREFIX, 2500, [3000, 2500, 4000]],
        ];

        foreach ($config as [$campagneRef, $seancePrefix, $montantFixe, $montantsLibres]) {
            for ($s = 0; $s < 3; $s++) {
                $seance = $this->getReference($seancePrefix . $s, Seance::class);

                for ($i = 0; $i < 5; $i++) {
                    $mode = $this->getReference(
                        ModeCotisationFixtures::PREFIX . $campagneRef . '-' . $i,

                        ModeCotisation::class
                    );

                    $cotisation = (new Cotisation())
                        ->setSeance($seance)
                        ->setModeCotisation($mode)
                        ->setMontant($i === 0 ? $montantsLibres[$s] : $montantFixe)
                        ->setCreatedAt(new \DateTimeImmutable());
                    $manager->persist($cotisation);
                }
            }
        }

        $manager->flush();
    }
}