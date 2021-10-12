<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilTestController extends AbstractController
{
    /**
     * @Route("/accueil/test", name="accueil_test")
     */
    public function index(): Response
    {
        return $this->render('accueil_test/index.html.twig', [
            'controller_name' => 'AccueilTestController',
        ]);
    }
}
