<?php

namespace App\Repository;

use App\Entity\WsGroupeUnite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WsGroupeUnite>
 */
class WsGroupeUniteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WsGroupeUnite::class);
    }

    /**pour trouver tous les noms de groupes d'unité afin de les afficher sur la carte!
     * ATTENTION au fait que cela va retourner un tableaux
     * */
    
    public function findAllGroupeUniteNames(): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT gu.name
            FROM App\Entity\WsGroupeUnite gu'
        );

        return $query->getResult();
    }

    //    /**
    //     * @return WsGroupeUnite[] Returns an array of WsGroupeUnite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('w.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?WsGroupeUnite
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
