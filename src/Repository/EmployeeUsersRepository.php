<?php

namespace App\Repository;

use App\Entity\EmployeeUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<EmployeeUsers>
 *
 * @method EmployeeUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmployeeUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmployeeUsers[]    findAll()
 * @method EmployeeUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeUsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmployeeUsers::class);
    }

    public function add(EmployeeUsers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EmployeeUsers $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function deleteEMP($id)
    {
        return $this->createQueryBuilder('e')
                    ->delete()
                    ->Where('e.id = :val')
                    ->setParameter('val', $id)
                    ->getQuery()

                    ->execute();
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof EmployeeUsers) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

//    /**
//     * @return EmployeeUsers[] Returns an array of EmployeeUsers objects
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

   public function findOneBySomeField($value): ?EmployeeUsers
   {
       return $this->createQueryBuilder('e')
           ->andWhere('e.id = :val')
           ->setParameter('val', $value)
           ->getQuery()
           ->getOneOrNullResult()
       ;
   }
}
