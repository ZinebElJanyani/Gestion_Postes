<?php

namespace App\Repository;

use App\Entity\EmployeeUsersPostes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<r()>
 *
 * @method EmployeeUsersPostes|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeUsersPostes|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeUsersPostes[]    findAll()
 * @method EmployeeUsersPostes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeUsersPostesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeUsersPostes::class);
    }

    public function add(EmployeeUsersPostes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // public function remove(EmployeeUsersPostes $entity, bool $flush = false): void
    // {
    //     $this->getEntityManager()->remove($entity);

    //     if ($flush) {
    //         $this->getEntityManager()->flush();
    //     }
    // }

//    /**
//     * @return EmployeeUsersPostes[] Returns an array of EmployeeUsersPostes objects
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

//    public function findOneBySomeField($value): ?EmployeeUsersPostes
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
