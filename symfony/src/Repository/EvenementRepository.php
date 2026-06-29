<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function findFiltered(?string $sort = null): array
    {
        $qb = $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->andWhere('e.dateStart > :now')
            ->setParameter('status', 'valide')
            ->setParameter('now', new \DateTimeImmutable());

        if ($sort === 'places') {
            $qb->orderBy('e.nbPlaces', 'DESC');
        } elseif ($sort === 'organisateur') {
            $qb
                ->join('e.organisateur', 'u')
                ->orderBy('u.pseudo', 'ASC');
        } else {
            $qb->orderBy('e.dateStart', 'ASC');
        }

        return $qb->getQuery()->getResult();
    }

    
    public function findUpcomingEvents(int $limit = 3): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.status = :status')
            ->andWhere('e.dateStart > :now')
            ->setParameter('status', 'valide')
            ->setParameter('now', new \DateTimeImmutable())
            ->orderBy('e.dateStart', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Evenement[] Returns an array of Evenement objects
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

    //    public function findOneBySomeField($value): ?Evenement
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
