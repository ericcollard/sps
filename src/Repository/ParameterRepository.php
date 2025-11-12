<?php

namespace App\Repository;

use App\Entity\Parameter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Integer;
use function PHPUnit\Framework\throwException;

/**
 * @extends ServiceEntityRepository<Parameter>
 */
class ParameterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parameter::class);
    }

    //    /**
    //     * @return Parameter[] Returns an array of Parameter objects
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

    //    public function findOneBySomeField($value): ?Parameter
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function getNumericParameter(string $paramName): float
    {
        $param = $this->createQueryBuilder('p')
            ->andWhere('p.name = :val')
            ->setParameter('val', $paramName)
            ->getQuery()
            ->getOneOrNullResult()
        ;
        if (!$param) return 0.0;

        return $param->getNumericValue();
    }

    public function getTransportCost(): float
    {
        return $this->getNumericParameter('TransportCost');
    }

    public function getDefaultLunchCost(): float
    {
        return $this->getNumericParameter('DefaultLunchCost');
    }

    public function getLockDelay(): float
    {
        return $this->getNumericParameter('LockDelay');
    }

    public function getHelpText(): float
    {
        return $this->getNumericParameter('Help');
    }
}
