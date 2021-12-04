<?php

namespace App\Controller;

use App\Repository\MailContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactAdminController extends AbstractController
{
    #[Route('/contact_admin', name: 'contact_admin')]
    public function index(MailContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('contact_admin/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }
}
