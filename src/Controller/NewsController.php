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
        $data = new SeachData();
        $data->page = $request->get('page', 1);

        //dd($request->query);
        $tag = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $tagArticle = [];
        foreach ($tag as $tag){
            if (count($tag->getListeArticles())>0){
                $tagArticle[] =$tag;
            }
        }

        $countTag = $request->query->get('searchTag');

        if ($countTag == null){
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

    #[Route('/news/{id}', name: 'news_views')]
    public function affichageNews(int $id, ArticlesRepository $repository): Response{
        $article = $repository->find($id);

        return $this->render('news/view.html.twig', [
            'article' => $article
        ]);
    }

}
