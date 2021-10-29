<?php

namespace App\Controller;

use App\Entity\Article;
use App\Service\DataBaseFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsController extends AbstractController
{
    #[Route('/news', name: 'news')]
    public function index(DataBaseFunction $baseFunction): Response{
        $articles = $baseFunction->fetchingObjectAll(Article::class);
        return $this->render('news/index.html.twig', ['articles' => $articles,]);
    }
}
