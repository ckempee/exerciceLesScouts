<?php

namespace App\Repository;

use App\Entity\WsUnite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WsUnite>
 */
class WsUniteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WsUnite::class);
    }


    //calcluler le nombre de membres présentsdans une unité
    //pour ça je séléctionne le nom de l'unité et dois joindre la table membre en calculant le nombre de fois que l'id est noté+groupépar nom
    public function countMembresByUnite(WsUnite $unite): int
    {
        return $this->createQueryBuilder('u')
            ->select('COUNT(m.id)')
            ->leftJoin('u.wsMembres', 'm')
            ->where('u = :unite')
            ->setParameter('unite', $unite)
            ->getQuery()
            ->getSingleScalarResult();
    }

//    /**
//     * @return WsUnite[] Returns an array of WsUnite objects
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

//    public function findOneBySomeField($value): ?WsUnite
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
