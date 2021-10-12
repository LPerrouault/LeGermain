<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OeuvresController extends AbstractController
{
    #[Route('/oeuvres', name: 'oeuvres')]
    public function index(): Response
    {
        return $this->render('oeuvres/index.html.twig', [
            'controller_name' => 'OeuvresController',
        ]);
    }
}
