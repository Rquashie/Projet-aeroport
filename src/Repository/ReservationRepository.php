<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Vol;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    //    /**
    //     * @return Reservation[] Returns an array of Reservation objects
    //
    //    public function findVilleDepartById($id): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
     * @throws \DateMalformedStringException
     */
    public function calculDateEcheance($date){
        $now = new \DateTime();
        $intervale = $date->diff($now);
        return $intervale->days ;

    }

    /**
     * @throws \DateMalformedStringException
     */
    public function augmentePrixBillet(Reservation $reservation , Vol $vol): void
    {
        $date = $reservation -> getRefVol() ->getDateDepart() ;
        $prix = $vol->getPrixBilletInitiale();
        $joursRestants = $this->calculDateEcheance($date);
       if($joursRestants <= 2){
           $reservation ->setPrixBillet($prix + 500);
       }
       else if($joursRestants <= 10){
           $reservation ->setPrixBillet($prix + 250);
       }
       else if ($joursRestants <=20){
           $reservation ->setPrixBillet($prix + 150);
       }
       else {
           $reservation ->setPrixBillet($prix + 50);
       }
    }
}
