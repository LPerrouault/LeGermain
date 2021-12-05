<?php

namespace App\Repository;

use App\Entity\type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method type|null find($id, $lockMode = null, $lockVersion = null)
 * @method type|null findOneBy(array $criteria, array $orderBy = null)
 * @method type[]    findAll()
 * @method type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, type::class);
    }

    // /**
    //  * @return type[] Returns an array of type objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySomeField($value)
    {
        $query = $this->createQueryBuilder('t')
            ->select('t.id')
            ->andWhere('t.libelle = :val')
            ->setParameter('val', $value);
        dd($query->getQuery()->getResult());

        return $query->getQuery()->getResult();
    }

}
