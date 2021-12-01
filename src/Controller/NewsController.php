<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Entity\Tag;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(ArticlesRepository $articlesRepository, Request $request): Response{
//       Initialisation du variable SearchDat qui stoque les article qui on des tag
//        Puis on lui attribue la page 1 qui nous permet de mettre en place une pagination d
//          des articles
        $data = new SeachData();
        $data->page = $request->get('page', 1);

//        Initialisation d'une variable tag qui contient tous les tag present dans la BD
//         que l'on stoque dans une array en verrifiant que chaque tag present dans la varriable
//        tag contient à un article attribué.
//        L'array sera ensuite envoyé au twig pour affichage
        $tag = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $tagArticle = [];
        foreach ($tag as $value){
            if (count($value->getListeArticles())>0){
                $tagArticle[] =$value;
            }
        }

//        On recuperre le nom du tag qui a ete selectionné dans le filtre
        $filterTag = $request->query->get('searchTag');
//        Si la valeur est null on effectue une requette qui affiche tous les article.
//        Sinon on effectue une requette qui affiche les article avec e tag selestionne
        if ($filterTag == null){
            $articles = $articlesRepository->findSearchFilter($data);
        }
        else{
            $articles = $articlesRepository->findSearchAfterFilter($request, $data);
        }


        return $this->render('news/index.html.twig', [
            'articles' => $articles,
            'tags' => $tagArticle
        ]);
    }

//    Route qui permet d'aficher en gros l'article selectionner (avec toutes les informations)
    #[Route('/news/{id}', name: 'news_views')]
    public function affichageNews(int $id, ArticlesRepository $repository): Response{
        $article = $repository->find($id);

        return $this->render('news/view.html.twig', [
            'article' => $article
        ]);
    }

}
