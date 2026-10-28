<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Membre;
use App\Entity\SeanceHebdomadaire;
use App\Entity\SeanceMensuelle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SeanceFixtures extends Fixture implements DependentFixtureInterface
{
    public const TONTINE_PREFIX = 'seance-tontine-';
    public const EPARGNE_PREFIX = 'seance-epargne-';

    public function getDependencies(): array
    {
        return [CampagneFixtures::class, UserFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $tontine = $this->getReference(CampagneFixtures::TONTINE, Campagne::class);
        foreach (['2026-01-05', '2026-02-05', '2026-03-05'] as $i => $date) {
            $seance = (new SeanceMensuelle())
                ->setCampagne($tontine)
                ->setDateSeance(new \DateTime($date))
                ->setBeneficiaire($this->getReference(UserFixtures::MEMBRE_PREFIX . $i, Membre::class));
            $manager->persist($seance);
            $this->addReference(self::TONTINE_PREFIX . $i, $seance);
        }

        $epargne = $this->getReference(CampagneFixtures::EPARGNE, Campagne::class);
        foreach (['2026-01-05', '2026-01-12', '2026-01-19'] as $i => $date) {
            $seance = (new SeanceHebdomadaire())
                ->setCampagne($epargne)
                ->setDateSeance(new \DateTime($date));
            $manager->persist($seance);
            $this->addReference(self::EPARGNE_PREFIX . $i, $seance);
        }

        $manager->flush();
    }
}