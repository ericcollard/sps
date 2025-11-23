<?php

namespace App\Repository;

use App\Entity\Family;
use App\Entity\Racer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @extends ServiceEntityRepository<Racer>
 */
class RacerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Racer::class);
    }

    public function getActiveCnt()
    {
        return $this->createQueryBuilder('r')
            ->select('COUNT(DISTINCT(r.id))')
            ->andWhere('r.licenseActivated = true')
            ->getQuery()
            ->getSingleScalarResult();
    }

        /**
         * @return Racer[] Returns an array of Racer objects
         */
        public function findByEvent($event): array
        {
            $racers = [];
            $racersBySkidays =  $this->createQueryBuilder('r')
                ->join('r.SkidayRacers','sr')
                ->join('sr.skiday','sd')
                ->join('sd.event','ev')
                ->andWhere('ev.id = :val')
                ->setParameter('val', $event->getId())
                ->getQuery()
                ->getResult()
            ;
            $racersByTransport =  $this->createQueryBuilder('r')
                ->join('r.transportRacers','tr')
                ->join('tr.transport','t')
                ->join('t.event','ev')
                ->andWhere('ev.id = :val')
                ->setParameter('val', $event->getId())
                ->getQuery()
                ->getResult()
            ;
            $racersByAccomodation =  $this->createQueryBuilder('r')
                ->join('r.accomodationsRacers','ar')
                ->join('ar.accomodation','a')
                ->join('a.event','ev')
                ->andWhere('ev.id = :val')
                ->setParameter('val', $event->getId())
                ->getQuery()
                ->getResult()
            ;
            foreach ($racersBySkidays as $racerBySkidays)
            {
                $racers[$racerBySkidays->getId()] = $racerBySkidays;
            }
            foreach ($racersByTransport as $racerByTransport)
            {
                if (!key_exists($racerByTransport->getId(),$racers ))
                    $racers[$racerByTransport->getId()] = $racerByTransport;
            }
            foreach ($racersByAccomodation as $racerByAccomodation)
            {
                if (!key_exists($racerByAccomodation->getId(),$racers ))
                    $racers[$racerByAccomodation->getId()] = $racerByAccomodation;
            }
            return $racers;
        }


        public function findAll(): array
        {
            return $this->createQueryBuilder('r')
                ->andWhere('r.licenseActivated = :val')
                ->setParameter('val', 1)
                ->orderBy('r.id', 'ASC')
                ->getQuery()
                ->getResult()
            ;
        }

    //    public function findOneBySomeField($value): ?Racer
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
