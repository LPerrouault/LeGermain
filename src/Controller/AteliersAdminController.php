<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AteliersAdminController extends AbstractController
{
    #[Route('/ateliers/admin', name: 'ateliers_admin')]
    public function index(): Response
    {
        return $this->render('ateliers_admin/index.html.twig', [
            'controller_name' => 'AteliersAdminController',
        ]);
    }
}
