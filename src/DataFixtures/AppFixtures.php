<?php

namespace App\DataFixtures;

use App\Entity\Amende;
use App\Entity\Cotisation;
use App\Entity\Epargne;
use App\Entity\Fonction;
use App\Entity\Groupement;
use App\Entity\Membre;
use App\Entity\ModeCotisation;
use App\Entity\Pret;
use App\Entity\Remboursement;
use App\Entity\Role;
use App\Entity\SeanceHebdomadaire;
use App\Entity\SeanceMensuelle;
use App\Entity\Tontine;
use App\Entity\TrancheTaux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Rôles et fonctions
        $admin = (new Role())->setNom('admin');
        $simple = (new Role())->setNom('membre simple');
        $tresorier = (new Fonction())->setNom('trésorier');
        $secretaire = (new Fonction())->setNom('secrétaire');
        foreach ([$admin, $simple, $tresorier, $secretaire] as $objet) {
            $manager->persist($objet);
        }

        // Groupement
        $groupement = (new Groupement())->setNom('Jappo Liggéey');
        $manager->persist($groupement);

        // Membres
        $donnees = [
            ['Awa Diop', $admin, null],
            ['Fatou Ndiaye', $simple, $tresorier],
            ['Aminata Sow', $simple, $secretaire],
            ['Khady Fall', $simple, null],
            ['Mariama Ba', $simple, null],
        ];
        $membres = [];
        foreach ($donnees as $i => [$nom, $role, $fonction]) {
            $membre = (new Membre())
                ->setNomComplet($nom)
                ->setTelephone(sprintf('77 100 00 %02d', $i))
                ->setAdresse('Dakar, Sénégal')
                ->setLogin('membre'.$i)
                ->setPassword(password_hash('password', PASSWORD_BCRYPT))
                ->setRole($role)
                ->setFonction($fonction)
                ->setGroupement($groupement);
            $manager->persist($membre);
            $membres[] = $membre;
        }

        // Campagnes
        $tontine = (new Tontine())
            ->setNom('Tontine mensuelle')
            ->setDateDebut(new \DateTime('2026-01-05'))
            ->setDateFin(new \DateTime('2026-12-31'))
            ->setMontant(10000)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setGroupement($groupement);
        $epargne = (new Epargne())
            ->setNom('Épargne solidaire')
            ->setDateDebut(new \DateTime('2026-01-05'))
            ->setMontant(2500)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setGroupement($groupement);

        // Affectation des membres : le premier cotise librement, les autres le montant fixe
        $modes = [];
        foreach ([$tontine, $epargne] as $c => $campagne) {
            $manager->persist($campagne);
            foreach ($membres as $i => $membre) {
                $mode = (new ModeCotisation())
                    ->setIsLibre(0 === $i)
                    ->setCampagne($campagne)
                    ->setMembre($membre);
                $manager->persist($mode);
                $modes[$c][] = $mode;
            }
        }

        // Séances mensuelles de la tontine, un bénéficiaire différent à chaque fois
        for ($s = 0; $s < 3; ++$s) {
            $seance = (new SeanceMensuelle())
                ->setDateSeance(new \DateTime("2026-01-05 +$s month"))
                ->setCampagne($tontine)
                ->setBeneficiaire($membres[$s]);
            $manager->persist($seance);
            foreach ($modes[0] as $mode) {
                $manager->persist((new Cotisation())
                    ->setSeance($seance)
                    ->setModeCotisation($mode)
                    ->setMontant($mode->isLibre() ? 5000 : 10000)
                    ->setCreatedAt(new \DateTimeImmutable()));
            }
        }

        // Séances hebdomadaires de l'épargne, sans bénéficiaire
        for ($s = 0; $s < 3; ++$s) {
            $seance = (new SeanceHebdomadaire())
                ->setDateSeance(new \DateTime('2026-01-05 +'.($s * 7).' days'))
                ->setCampagne($epargne);
            $manager->persist($seance);
            foreach ($modes[1] as $mode) {
                $manager->persist((new Cotisation())
                    ->setSeance($seance)
                    ->setModeCotisation($mode)
                    ->setMontant($mode->isLibre() ? 1000 * ($s + 1) : 2500)
                    ->setCreatedAt(new \DateTimeImmutable()));
            }
        }

        // Barème des taux, prêt, remboursements et amende
        foreach ([[0, 50000, 5.0], [50001, 200000, 8.0]] as [$min, $max, $taux]) {
            $manager->persist((new TrancheTaux())
                ->setMontantMin($min)
                ->setMontantMax($max)
                ->setTaux($taux)
                ->setEpargne($epargne));
        }

        $pret = (new Pret())
            ->setMontant(40000)
            ->setDateDebut(new \DateTime('2026-02-01'))
            ->setDateFin(new \DateTime('2026-05-01'))
            ->setTauxApplique(5.0)
            ->setEpargne($epargne)
            ->setEmprunteur($membres[3]);
        $manager->persist($pret);

        $paye = (new Remboursement())
            ->setMontant(14000)
            ->setDateEcheance(new \DateTime('2026-03-01'))
            ->setDatePaiement(new \DateTime('2026-03-10'))
            ->setPret($pret);
        $manager->persist($paye);

        $manager->persist((new Remboursement())
            ->setMontant(14000)
            ->setDateEcheance(new \DateTime('2026-04-01'))
            ->setPret($pret));

        $manager->persist((new Amende())
            ->setMontant(500)
            ->setMotif('Retard de paiement de 9 jours')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setRemboursement($paye));

        $manager->flush();
    }
}