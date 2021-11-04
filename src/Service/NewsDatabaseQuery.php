<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class NewsDatabaseQuery extends ServiceEntityRepository
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
    public function findSearch(SearchData $searchData) : PaginationInterface
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