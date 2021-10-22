<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactAdminController extends AbstractController
{
    #[Route('/contact/admin', name: 'contact_admin')]
    public function index(): Response
    {
        return $this->render('contact_admin/index.html.twig', [
            'controller_name' => 'ContactAdminController',
        ]);
    }
}
