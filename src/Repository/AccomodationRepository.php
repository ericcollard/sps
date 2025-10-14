<?php

namespace App\Repository;

use App\Entity\Accomodation;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Accomodation>
 */
class AccomodationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accomodation::class);
    }

//    /**
//     * @return Accomodation[] Returns an array of Accomodation objects
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

//    public function findOneBySomeField($value): ?Accomodation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findOneByEventAndDate(Event $event,  \DateTime $dayDate): ?Accomodation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.event = :event')
            ->andWhere('a.dayDate = :dayDate')
            ->setParameter('dayDate', $dayDate)
            ->setParameter('event', $event)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
