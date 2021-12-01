<?php

namespace App\Repository;

use App\DataFixtures\SeachData;
use App\Entity\Oeuvre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Service\TestData;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Oeuvre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oeuvre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oeuvre[]    findAll()
 * @method Oeuvre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OeuvreRepository extends ServiceEntityRepository
{

    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Oeuvre::class);
        $this->paginator = $paginator;
    }

    /**
     * @return PaginationInterface
     */
//    Requette qui effectue la recherche de tous les oeuvres
    public function findSearchFilter(SeachData $searchData) : PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('o')
            ->select('o');

        if (!empty($searchData->tags)){
            $query = $query
                ->andWhere('t.id IN (:listeOeuvre)')
                ->setParameter('listeOeuvre', $searchData->tags);
        }

        $query=$query->getQuery();
       // dd($query);
        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }

//  Requette qui effectue une recherche de toutes les oeuvre qui on le tag selectionné
    public function findSearchTag(Request $request, SeachData $searchData): PaginationInterface
    {
        $oeuvreTag = array_keys($request->query->get('searchTag'));
            $query = $this
                ->createQueryBuilder('o')
                ->select('t', 'o')
                ->join('o.listeTags', 't')
                ->andWhere('t.libelle IN (:tagOeuvre)')
                ->setParameter('tagOeuvre', $oeuvreTag);

        $query=$query->getQuery();

        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }

//  Requette qui effectue une recherche de toutes les oeuvre qui on ce type selectionné
    public function findSearchType(Request $request, SeachData $searchData): PaginationInterface
    {
        $oeuvreType = array_keys($request->query->get('searchType'));
        $query = $this
            ->createQueryBuilder('o')
            ->select('t', 'o')
            ->join('o.idType', 't')
            ->andWhere('t.libelle IN (:typeOeuvre)')
            ->setParameter('typeOeuvre', $oeuvreType);

        $query=$query->getQuery();

        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }

//  Requette qui effectue une recherche de toutes les oeuvre qui on le type et le tag selectionné
    public function findSearchTagAndType(Request $request, SeachData $searchData): PaginationInterface
    {
        $oeuvreTag = array_keys($request->query->get('searchTag'));
        $oeuvreType = array_keys($request->query->get('searchType'));
        $query = $this
            ->createQueryBuilder('o')
            ->select('tag','type', 'o')
            ->join('o.listeTags', 'tag')
            ->join('o.idType', 'type')
            ->andWhere('tag.libelle IN (:tagOeuvre)')
            ->andWhere('type.libelle IN (:typeOeuvre)')
            ->setParameter('typeOeuvre', $oeuvreType)
            ->setParameter('tagOeuvre', $oeuvreTag);


        $query=$query->getQuery();

        return $this->paginator->paginate(
            $query,
            $searchData->page,
            10
        );
    }
}
