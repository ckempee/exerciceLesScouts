<?php


namespace App\Repository;

use App\Entity\WsSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<WsSection>
 */
class WsSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WsSection::class);
    }
    
//méthode qui calcule le nombre de membres par branche. Combien de louveateaux? Combien de baladins?
//
    public function membresParBranche(): array
    {
        $qb = $this->createQueryBuilder('s')
        ->select('b.name AS branche, COUNT(m.id) AS total')
        ->join('s.wsMembres', 'm')
        ->join('s.branche', 'b')
        ->groupBy('b.name');
        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function countMembersByUnite($uniteId): int
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(m.id)')
            ->join('s.wsMembres', 'm')
            ->join('s.unite', 'u')
            ->where('u.id = :uniteId')
            ->setParameter('uniteId', $uniteId)
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function membresParBrancheDansUnite($uniteId): array
{
    return $this->createQueryBuilder('s')
        ->select('b.name AS branche, COUNT(m.id) AS total')
        ->join('s.wsMembres', 'm')
        ->join('s.branche', 'b')
        ->where('s.unite = :uniteId')
        ->groupBy('b.name')
        ->setParameter('uniteId', $uniteId)
        ->getQuery()
        ->getResult();
}

  
    //    /**
    //     * @return WsSection[] Returns an array of WsSection objects
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

    //    public function findOneBySomeField($value): ?WsSection
    //    {
    //        return $this->createQueryBuilder('w')
    //            ->andWhere('w.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
