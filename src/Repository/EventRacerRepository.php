<?php

namespace App\Repository;

use App\Entity\EventRacer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventRacer>
 */
class EventRacerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRacer::class);
    }

    //    /**
    //     * @return EventRacer[] Returns an array of EventRacer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function findOneByEventAndRacer($event, $racer): ?EventRacer
        {
            return $this->createQueryBuilder('e')
                ->andWhere('e.racer = :val1')
                ->andWhere('e.event = :val2')
                ->setParameter('val1', $racer)
                ->setParameter('val2', $event)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

}
