<?php

namespace App\Repository;

use App\Entity\Pricetemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pricetemplate>
 */
class PricetemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pricetemplate::class);
    }

    //    /**
    //     * @return Pricetemplate[] Returns an array of Pricetemplate objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function findOneByParameters($skidayCnt, $accomodationCnt, $skipassCnt): ?Pricetemplate
        {
            return $this->createQueryBuilder('p')
                ->andWhere('p.skiday = :p1')
                ->andWhere('p.accomodation = :p2')
                ->andWhere('p.skipass = :p3')
                ->setParameter('p1', $skidayCnt)
                ->setParameter('p2', $accomodationCnt)
                ->setParameter('p3', $skipassCnt)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
