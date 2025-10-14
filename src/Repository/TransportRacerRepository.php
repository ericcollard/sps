<?php

namespace App\Repository;

use App\Entity\Racer;
use App\Entity\Transport;
use App\Entity\TransportRacer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TransportRacer>
 */
class TransportRacerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportRacer::class);
    }

    //    /**
    //     * @return TransportRacer[] Returns an array of TransportRacer objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

        public function getRacerRegistration(Racer $racer,Transport $transport): ?TransportRacer
        {
            return $this->createQueryBuilder('tr')
                ->andWhere('tr.transport = :transport')
                ->andWhere('tr.racer = :racer')
                ->setParameter('transport', $transport)
                ->setParameter('racer', $racer)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
