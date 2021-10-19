<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsAdminController extends AbstractController
{
    #[Route('/news/admin', name: 'news_admin')]
    public function index(): Response
    {
        return $this->render('news_admin/index.html.twig', [
            'controller_name' => 'NewsAdminController',
        ]);
    }
}
