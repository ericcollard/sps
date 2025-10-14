<?php

namespace App\Repository;

use App\Entity\Accomodation;
use App\Entity\AccomodationRacer;
use App\Entity\Racer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccomodationRacer>
 */
class AccomodationRacerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccomodationRacer::class);
    }

    //    /**
    //     * @return AccomodationRacer[] Returns an array of AccomodationRacer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?AccomodationRacer
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function getRacerRegistration(Racer $racer,Accomodation $accomodation): ?AccomodationRacer
    {
        return $this->createQueryBuilder('ar')
            ->andWhere('ar.accomodation = :accomodation')
            ->andWhere('ar.racer = :racer')
            ->setParameter('accomodation', $accomodation)
            ->setParameter('racer', $racer)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
