<?php

namespace App\Repository;

use App\DataFixtures\SeachData;
use App\Entity\Article;
use App\Entity\Inscription;
use App\Service\TestData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ArticlesRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Article::class);
        $this->paginator = $paginator;
    }

    /**
     * @return PaginationInterface
     */
    public function findSearch(SeachData $searchData) : PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('n')
            ->select('t', 'n')
            ->join('n.listeTags', 't');

        if (!empty($searchData->tags)){
            $query = $query
                ->andWhere('t.id IN (:listeTags)')
                ->setParameter('listeTags', $searchData->tags);
        }

        $query=$query->getQuery();

        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }
}