<?php

namespace App\Repository;

use App\Entity\Vol;
use Cassandra\Date;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Scalar\Float_;

/**
 * @extends ServiceEntityRepository<Vol>
 */
class VolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vol::class);
    }


    //    /**
    //     * @return Vol[] Returns an array of Vol objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vol
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function searchByDestination(?string $destination,?string $date ,?float $prix): array
    {
        $qb = $this->createQueryBuilder('v');

        if ($destination) {
            $qb->andWhere('v.villeArrive LIKE :destination')
                ->setParameter('destination', '%'.$destination.'%');
        }

        if ($date) {
            try {
                $dateObj = new \DateTime($date);
                $qb->andWhere('v.dateDepart = :date')
                    ->setParameter('date', $dateObj->format('Y-m-d'));
            } catch (\Exception $e) {
                // gestion si la date est invalide
            }
        }

        if ($prix !== null) {
            $qb->andWhere('v.prixBilletInitiale <= :prix')
                ->setParameter('prix', $prix);
        }

        return $qb->getQuery()->getResult();
    }
}
