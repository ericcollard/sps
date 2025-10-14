<?php

namespace App\Repository;

use App\Entity\Family;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Family>
 */
class FamilyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Family::class);
    }

    /**
     * @return Family[] Returns an array of Event objects
     */
    public function findOneByLogin(string $email): ?Family
    {
        $qb = $this->createQueryBuilder('f')
            ->leftJoin('f.contacts', 'c')
            ->where('c.value = :email')
            ->andWhere('c.type = :typeLogin')
            ->setParameter('email', $email)
            ->setParameter('typeLogin', 'Login')
        ;
        $result = $qb->getQuery()->getResult();

        if (count($result) > 1)
        {
            throw new \Exception('Plusieurs Familles correspondent au login : '.$email);
        }

        if (count($result) > 0)
            return $result[0];

        return null;
    }



    //    /**
    //     * @return Family[] Returns an array of Family objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Family
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
