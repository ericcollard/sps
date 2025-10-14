<?php

namespace App\Repository;

use App\Entity\Racer;
use App\Entity\Skiday;
use App\Entity\SkidayRacer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkidayRacer>
 */
class SkidayRacerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkidayRacer::class);
    }

    //    /**
    //     * @return SkidayRacer[] Returns an array of SkidayRacer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SkidayRacer
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getRacerRegistration(Racer $racer,Skiday $skiday): ?SkidayRacer
    {
        return $this->createQueryBuilder('sr')
            ->andWhere('sr.skiday = :skiday')
            ->andWhere('sr.racer = :racer')
            ->setParameter('skiday', $skiday)
            ->setParameter('racer', $racer)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
