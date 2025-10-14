<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }


    /**
    * @return Event[] Returns an array of Event objects
    */
    public function findByDate(\DateTime $searchedDate): array
    {
        $searchedDate->setTime(0,0,0);
        //dd($lastDate);

        $qb = $this->createQueryBuilder('e')
            ->where('e.startdate <= :firstDate')
            ->andWhere('e.enddate >= :lastDate')
            ->setParameter('firstDate', $searchedDate)
            ->setParameter('lastDate', $searchedDate)
        ;
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    //    /**
    //     * @return Event[] Returns an array of Event objects
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

    //    public function findOneBySomeField($value): ?Event
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
