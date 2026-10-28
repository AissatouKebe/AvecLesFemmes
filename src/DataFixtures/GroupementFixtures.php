<?php

namespace App\DataFixtures;

use App\Entity\Groupement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupementFixtures extends Fixture
{
    public const REFERENCE_PREFIX = 'groupement-';

    public function load(ObjectManager $manager): void
    {
        $data = [
            ['GIE Teranga Mbour', '+221 77 123 45 67', 'Mbour, Thiès'],
            ['GIE Jappo Dakar', '+221 78 234 56 78', 'Pikine, Dakar'],
            ['GIE Dëgg Saint-Louis', '+221 76 345 67 89', 'Sor, Saint-Louis'],
        ];

        foreach ($data as $i => [$nom, $tel, $adresse]) {
            $groupement = (new Groupement())
                ->setNom($nom)
                ->setTel($tel)
                ->setAdresse($adresse);
            $manager->persist($groupement);
            $this->addReference(self::REFERENCE_PREFIX . $i, $groupement);
        }

        $manager->flush();
    }
}