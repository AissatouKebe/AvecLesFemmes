<?php

namespace App\DataFixtures;

use App\Entity\Fonction;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\Role;
use App\Entity\SupAdmin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const MEMBRE_PREFIX = 'membre-';

    public function getDependencies(): array
    {
        return [RoleFixtures::class, FonctionFixtures::class, GroupementFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $motDePasse = password_hash('password', PASSWORD_BCRYPT);

        $supAdmin = (new SupAdmin())
            ->setNomComplet('Super Administrateur')
            ->setTelephone('+221 77 000 00 00')
            ->setAdresse('Dakar')
            ->setLogin('supadmin')
            ->setPassword($motDePasse);
        $manager->persist($supAdmin);

        $groupement = $this->getReference(GroupementFixtures::REFERENCE_PREFIX . '0', Groupement::class);

        $data = [
            ['Awa Diop', '+221 77 100 00 01', 'Mbour', RoleFixtures::ADMIN, null],
            ['Fatou Ndiaye', '+221 77 100 00 02', 'Mbour', RoleFixtures::MEMBRE_SIMPLE, FonctionFixtures::TRESORIER],
            ['Aminata Sow', '+221 77 100 00 03', 'Mbour', RoleFixtures::MEMBRE_SIMPLE, FonctionFixtures::SECRETAIRE],
            ['Khady Fall', '+221 77 100 00 04', 'Mbour', RoleFixtures::MEMBRE_SIMPLE, null],
            ['Mariama Ba', '+221 77 100 00 05', 'Mbour', RoleFixtures::MEMBRE_SIMPLE, null],
        ];

        foreach ($data as $i => [$nom, $tel, $adresse, $roleRef, $fonctionRef]) {
            $membre = (new Membre())
                ->setNomComplet($nom)
                ->setTelephone($tel)
                ->setAdresse($adresse)
                ->setLogin('membre' . $i)
                ->setPassword($motDePasse)
                ->setRole($this->getReference($roleRef, Role::class))
                ->setFonction($fonctionRef ? $this->getReference($fonctionRef, Fonction::class) : null)
                ->setGroupement($groupement);
            $manager->persist($membre);
            $this->addReference(self::MEMBRE_PREFIX . $i, $membre);
        }

        $manager->flush();
    }
}