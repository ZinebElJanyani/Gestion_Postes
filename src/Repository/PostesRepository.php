<?php

namespace App\Repository;

use App\Entity\Postes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Postes>
 *
 * @method Postes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postes[]    findAll()
 * @method Postes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postes::class);
    }

    public function add(Postes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Postes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function deletePOSTE($id)
    {
        return $this->createQueryBuilder('p')
                    ->delete()
                    ->Where('p.id = :val')
                    ->setParameter('val', $id)
                    ->getQuery()

                    ->execute();
    }

//    /**
//     * @return Postes[] Returns an array of Postes objects
//     */
   public function findByExampleField($value): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.plateau = :val')
           ->setParameter('val', $value)
           ->orderBy('p.id', 'ASC')
        //    ->setMaxResults(10)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findOneBySomeField($value): ?Postes
   {
       return $this->createQueryBuilder('p')
           ->Where('p.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
