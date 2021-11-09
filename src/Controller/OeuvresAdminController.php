<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OeuvresAdminController extends AbstractController
{
    #[Route('/oeuvres/admin', name: 'oeuvres_admin')]
    public function index(): Response
    {
        return $this->render('oeuvres_admin/index.html.twig', [
            'controller_name' => 'OeuvresAdminController',
        ]);
    }
}
