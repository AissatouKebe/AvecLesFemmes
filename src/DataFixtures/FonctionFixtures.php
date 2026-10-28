<?php

namespace App\DataFixtures;

use App\Entity\Fonction;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FonctionFixtures extends Fixture
{
    public const TRESORIER = 'fonction-tresorier';
    public const SECRETAIRE = 'fonction-secretaire';

    public function load(ObjectManager $manager): void
    {
        $data = [
            self::TRESORIER => 'trésorier',
            self::SECRETAIRE => 'secrétaire',
        ];

        foreach ($data as $reference => $nom) {
            $fonction = (new Fonction())->setNom($nom);
            $manager->persist($fonction);
            $this->addReference($reference, $fonction);
        }

        $manager->flush();
    }
}