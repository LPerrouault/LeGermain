<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AteliersAdminController extends AbstractController
{
    #[Route('/admin/ateliers', name: 'ateliers_admin')]
    public function index(): Response
    {
        return $this->render('admin/ateliers_admin/index.html.twig', [
            'controller_name' => 'AteliersAdminController',
        ]);
    }
}
