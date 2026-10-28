<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const ADMIN = 'role-admin';
    public const MEMBRE_SIMPLE = 'role-membre-simple';

    public function load(ObjectManager $manager): void
    {
        $data = [
            self::ADMIN => 'admin',
            self::MEMBRE_SIMPLE => 'membre simple',
        ];

        foreach ($data as $reference => $nom) {
            $role = (new Role())->setNom($nom);
            $manager->persist($role);
            $this->addReference($reference, $role);
        }

        $manager->flush();
    }
}