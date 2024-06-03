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
