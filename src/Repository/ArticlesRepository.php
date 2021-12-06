<?php

namespace App\Repository;

use App\DataFixtures\SeachData;
use App\Entity\Article;
use App\Entity\Tag;
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
    //requette SQL pour determiner les article qui sont dans tag par l'intermediaire de la table article_tag
    public function findSearchFilter(SeachData $searchData) : PaginationInterface
    {
        $query = $this
            ->createQueryBuilder('articles')
            ->select('t', 'articles')
            ->orderBy('articles.dateHeureEnregistrement', 'DESC')
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

//     requette SQL pour determiner les article qui sont dans tag par l'intermediaire de la table article_tag
//     quand on aplique une action sur le filtre

    public function findSearchAfterFilter(Request $request, SeachData $searchData): PaginationInterface
    {
        $articleTag = array_keys($request->query->get('searchTag'));

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

    public function updateArticle($id, $titre, $nomFichier , $corpsArticle){
       if ($id!=null) {
           $query = $this
               ->createQueryBuilder('articles')
               ->update();
           if ($titre != null && $nomFichier != null && $corpsArticle != null){
               $query->set('articles.titre', ':titre')
                      ->set('articles.nomFichierImage', ':nomFichier')
                      ->set('articles.corpsArticle', ':corpsArticle')
                      ->setParameter('titre', $titre)
                      ->setParameter('nomFichier', $nomFichier)
                      ->setParameter('corpsArticle', $corpsArticle);

           }
           elseif ($titre != null) {
               $query->set('articles.titre', ':titre')
                      ->setParameter('titre', $titre);

           } elseif ($nomFichier != null) {
               $query->set('articles.nomFichierImage', ':nomFichier')
                     ->setParameter('nomFichier', $nomFichier);

           } elseif ($corpsArticle == null) {
               $query->set('articles.corpsArticle', ':corpsArticle')
                     ->setParameter('corpsArticle', $corpsArticle);
           }
           $query->where('articles.id = ?2')
               ->setParameter(2, $id);

           return $query->getQuery()->getResult();
       }

    }

}