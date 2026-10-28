<?php

namespace App\DataFixtures;

use App\Entity\Campagne;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModeCotisationFixtures extends Fixture implements DependentFixtureInterface
{
    public const PREFIX = 'mode-cotisation-';

    public function getDependencies(): array
    {
        return [UserFixtures::class, CampagneFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ([CampagneFixtures::TONTINE, CampagneFixtures::EPARGNE] as $campagneRef) {
            $campagne = $this->getReference($campagneRef, Campagne::class);

            for ($i = 0; $i < 5; $i++) {
                $membre = $this->getReference(UserFixtures::MEMBRE_PREFIX . $i, Membre::class);

                $mode = (new ModeCotisation())
                    ->setCampagne($campagne)
                    ->setMembre($membre)
                    ->setIsLibre($i === 0);
                $manager->persist($mode);
                $this->addReference(self::PREFIX . $campagneRef . '-' . $i, $mode);
            }
        }

        $manager->flush();
    }
}