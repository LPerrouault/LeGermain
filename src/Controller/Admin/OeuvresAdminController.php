<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OeuvresAdminController extends AbstractController
{
    #[Route('/admin/oeuvres', name: 'oeuvres_admin')]
    public function index(): Response
    {
        return $this->render('admin/oeuvres_admin/index.html.twig', [
            'controller_name' => 'OeuvresAdminController',
        ]);
    }
}
