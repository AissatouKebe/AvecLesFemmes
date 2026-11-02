<?php

namespace App\Repository;

use App\Entity\Groupement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Groupement>
 */
class GroupementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Groupement::class);
    }

    /**
     * Affiche + recherche (ville ou téléphone) + pagine en une seule requête.
     *
     * @return Paginator<Groupement>
     */
    public function rechercher(?string $recherche, int $page, int $parPage): Paginator
    {
        $qb = $this->createQueryBuilder('g')
            ->leftJoin('g.exercices', 'e')
            ->addSelect('e')
            ->orderBy('g.nom', 'ASC');

        if ($recherche !== null) {
            // pas de champ ville : on cherche dans l'adresse, ou dans le téléphone
            $qb->andWhere('(LOWER(g.adresse) LIKE :q OR g.tel LIKE :q)')
               ->setParameter('q', '%' . mb_strtolower($recherche) . '%');
        }

        $qb->setFirstResult(($page - 1) * $parPage)
           ->setMaxResults($parPage);

        return new Paginator($qb->getQuery(), fetchJoinCollection: true);
    }

//    /**
//     * @return Groupement[] Returns an array of Groupement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Groupement
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
