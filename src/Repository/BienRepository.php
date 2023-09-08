<?php

namespace App\Repository;

use App\Entity\Bien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bien>
 *
 * @method Bien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bien[]    findAll()
 * @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

    /**
     * @return Bien[] Returns an array of Bien objects
     */
    public function listBiensDispoApresDate(string $date): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.dateDispo >= :date')
            ->setParameter('date', $date)
            ->orderBy('b.nom')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Bien[] Returns an array of Bien objects
     */
    public function listBiensDispoApresDateByDept(string $date, int $dept = null): array
    {
        $qb = $this->createQueryBuilder('b')
            ->andWhere('b.nom = :recherche')
            ->setParameter('date', $date);

        if($dept != null) {

            $qb->join('b.ville', 'ville')
                ->andWhere('ville.codePostal', $dept);
        }

        return $qb->join('ville.foodTrucks', 'ft')
            ->andWhere('ft.typeCuisine', 'burger')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @return Bien[] Returns an array of Bien objects
     */
    public function listBienSortedBy($sort, $direction): array
    {
        $qb = $this->createQueryBuilder('b');

        if($sort == "prix"){
            $qb->orderBy('b.prix',$direction);
        }elseif($sort == "nom_decroissant"){
            $qb->orderBy('b.nom',$direction);
        }

        return $qb->getQuery()->getResult();
    }



}
