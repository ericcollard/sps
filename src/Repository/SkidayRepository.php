<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Skiday;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Skiday>
 */
class SkidayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skiday::class);
    }

    /**
     * @return Skiday[] Returns an array of Event objects
     */
    public function findOneByDate(\DateTime $searchedDate): ?Skiday
    {
        $searchedDateStart = clone $searchedDate;
        $searchedDateStop = clone $searchedDate;
        $searchedDateStart->setTime(0,0,0);
        $searchedDateStop->setTime(23,59,59);

        $qb = $this->createQueryBuilder('s')
            ->where('s.dayDate <= :searchedDateStop')
            ->andWhere('s.dayDate >= :searchedDateStart')
            ->setParameter('searchedDateStop', $searchedDateStop)
            ->setParameter('searchedDateStart', $searchedDateStart)
        ;
        $result = $qb->getQuery()->getResult();

        if (count($result) > 1)
        {
            throw new \Exception('Plusieurs Sakiday défini pour le même jour : '.$searchedDate->format('d/m/Y'));
        }

        if (count($result) > 0)
            return $result[0];

        return null;
    }

    //    public function findOneBySomeField($value): ?Skiday
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
