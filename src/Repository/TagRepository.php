<?php

namespace App\Repository;

use App\DataFixtures\SeachData;
use App\Entity\Article;
use App\Entity\tag;
use Couchbase\SearchSortGeoDistance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Array_;
use function Symfony\Component\Translation\t;

/**
 * @method tag|null find($id, $lockMode = null, $lockVersion = null)
 * @method tag|null findOneBy(array $criteria, array $orderBy = null)
 * @method tag[]    findAll()
 * @method tag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagRepository extends ServiceEntityRepository
{
    /**
     * @var int
     */
    public $page =1;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, tag::class);
    }

    public function serachId($libelle){
        $query = $this
            ->createQueryBuilder('tag')
            ->select('tag.id')
             ->andWhere('tag.libelle IN (:tagArticle)')
            ->setParameter('tagArticle', $libelle);

        return $query->getQuery()->getResult();
    }

    public function searchTag($idArticle) {
        $query = $this
            ->createQueryBuilder('tag')
            ->select('tag', 'article')
            ->join('tag.listeArticles', 'article')
            ->andWhere('article.id IN (:tagArticle)')
            ->setParameter('tagArticle',$idArticle);

        return $query->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }

   public function filterTag()
   {
       $query = $this->createQueryBuilder('t')
                    ->leftJoin(Article::class, 'a')
                    ->where('t.listeArticles = a.listeTags')
                    ->getQuery()
                    ->getResult();

        return $query;
   }
}
