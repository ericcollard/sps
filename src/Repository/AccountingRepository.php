<?php

namespace App\Repository;

use App\Entity\Accounting;
use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Accounting>
 */
class AccountingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accounting::class);
    }

    /**
    * @return Accounting[] Returns an array of Accounting objects
    */
    public function findByFamily($familyId): array
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.family','f')
            ->leftJoin('a.racer','r')
            ->leftJoin('r.family','rf')
            ->addSelect('f')
            ->addSelect('r')
            ->addSelect('rf')
            ->orWhere('f.id = :familyId')
            ->orWhere('rf.id = :familyId')
            ->orderBy('a.ImputationDate','ASC')
            ->setParameter('familyId', $familyId)
            ->getQuery()
            ->getResult();
    }

    public function getAccountingPositionForFamily($familyId)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.family','f')
            ->leftJoin('a.racer','r')
            ->leftJoin('r.family','rf')
            ->orWhere('f.id = :familyId')
            ->orWhere('rf.id = :familyId')
            ->setParameter('familyId', $familyId)
            ->select('SUM(a.value) as position')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAccountingPosition()
    {
        return $this->createQueryBuilder('a')
            ->select('SUM(a.value) as position')
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    public function findOneBySomeField($value): ?Accounting
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
