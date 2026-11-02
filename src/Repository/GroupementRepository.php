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
     * Affiche + filtre + pagine en une seule requête (les exercices sont chargés par la jointure).
     *
     * @return Paginator<Groupement>
     */
    public function rechercher(?string $ville, ?string $tel, int $page, int $parPage): Paginator
    {
        $qb = $this->createQueryBuilder('g')
            ->leftJoin('g.exercices', 'e')
            ->addSelect('e')
            ->orderBy('g.nom', 'ASC');

        if ($ville !== null) {
            // pas de champ ville : on cherche dans l'adresse
            $qb->andWhere('LOWER(g.adresse) LIKE :ville')
               ->setParameter('ville', '%' . mb_strtolower($ville) . '%');
        }

        if ($tel !== null) {
            $qb->andWhere('g.tel LIKE :tel')
               ->setParameter('tel', '%' . $tel . '%');
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
