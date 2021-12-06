<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsAdminController extends AbstractController
{
    #[Route('/admin/news', name: 'news_admin')]
    public function index(): Response
    {
        return $this->render('admin/news_admin/index.html.twig', [
            'controller_name' => 'NewsAdminController',
        ]);
    }
}
