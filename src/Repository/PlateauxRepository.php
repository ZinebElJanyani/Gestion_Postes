<?php

namespace App\Repository;

use App\Entity\Plateaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plateaux>
 *
 * @method Plateaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plateaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plateaux[]    findAll()
 * @method Plateaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plateaux::class);
    }

    public function add(Plateaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Plateaux $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function deletePLATEAU($id)
    {
        return $this->createQueryBuilder('pL')
                    ->delete()
                    ->Where('pL.id = :val')
                    ->setParameter('val', $id)
                    ->getQuery()

                    ->execute();
    }

//    /**
//     * @return Plateaux[] Returns an array of Plateaux objects
//     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.departement = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Plateaux
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
