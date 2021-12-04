<?php

namespace App\Repository;

use App\Entity\Type;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Type|null find($id, $lockMode = null, $lockVersion = null)
 * @method Type|null findOneBy(array $criteria, array $orderBy = null)
 * @method Type[]    findAll()
 * @method Type[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Type::class);
    }



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
