<?php

namespace App\DataFixtures;

use App\Entity\Cotisation;
use App\Entity\Epargne;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use App\Entity\Seance;
use App\Entity\Tontine;
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
            [CampagneFixtures::TONTINE, Tontine::class, 10000, [12000, 10000, 15000]],
            [CampagneFixtures::EPARGNE, Epargne::class, 2500, [3000, 2500, 4000]],
        ];

        foreach ($config as [$campagneRef, $campagneClasse, $montantFixe, $montantsLibres]) {
            $campagne = $this->getReference($campagneRef, $campagneClasse);

            $seances = $manager->getRepository(Seance::class)
                ->findBy(['campagne' => $campagne], ['dateSeance' => 'ASC']);

            $modes = [];
            for ($i = 0; $i < 5; $i++) {
                $membre = $this->getReference(UserFixtures::MEMBRE_PREFIX . $i, Membre::class);
                $modes[$i] = $manager->getRepository(ModeCotisation::class)
                    ->findOneBy(['campagne' => $campagne, 'membre' => $membre]);
            }

            foreach ($seances as $s => $seance) {
                foreach ($modes as $i => $mode) {
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