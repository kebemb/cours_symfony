<?php

namespace App\Repository;

use App\Entity\BienUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BienUser>
 *
 * @method BienUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method BienUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method BienUser[]    findAll()
 * @method BienUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BienUser::class);
    }

//    /**
//     * @return BienUser[] Returns an array of BienUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?BienUser
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
