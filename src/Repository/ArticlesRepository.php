<?php

namespace App\Repository;

use App\DataFixtures\SeachData;
use App\Entity\Article;
use App\Service\TestData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use function Doctrine\ORM\QueryBuilder;

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
    public function findSearchFilter(SeachData $searchData) : PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('articles')
            ->select('t', 'articles')
            ->join('articles.listeTags', 't');

        if (!empty($searchData->tags)){
            $query = $query
                ->andWhere('t.id IN (:listeArticle)')
                ->setParameter('listeArticle', $searchData->tags);
        }

        $query=$query->getQuery();

        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }

    public function findSearchAfterFilter(Request $request, SeachData $searchData): PaginationInterface
    {
        $articleTag = array_keys($request->query->get('searchTag'));
        // dd($articleTag);

        $query = $this
            ->createQueryBuilder('a')
            ->select('t', 'a')
            ->join('a.listeTags', 't')
            ->andWhere('t.libelle IN (:tagArticle)')
            ->setParameter('tagArticle', $articleTag);

        $query=$query->getQuery();

        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }
}