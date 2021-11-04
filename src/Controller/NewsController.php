<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Entity\Article;
use App\Entity\tag;
use App\Form\SearchForm;
use App\Repository\ArticlesRepository;
use App\Service\DataBaseFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(DataBaseFunction $baseFunction, ArticlesRepository $databaseQuery , Request $request): Response{
        $data = new SeachData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $articles = $databaseQuery->findSearch($data);

        return $this->render('news/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView()
        ]);
    }
}
