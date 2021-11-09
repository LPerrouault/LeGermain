<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Atelier;

class AteliersController extends AbstractController
{
    #[Route('/ateliers', name: 'ateliers')]
    public function index(): Response{

        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $ateliers = $repo->findAll();

        return $this->render('ateliers/index.html.twig', [
                'controller_name' => 'AteliersController',
                'ateliers' => $ateliers
        ]);
    }

    #[Route('/ateliers/{id}', name: 'ateliers_details')]
    public function ateliersDetails($id){

        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $atelier = $repo->find($id);

        return $this->render('ateliers/details.html.twig', [
            'atelier' => $atelier
        ]);
    }

    /**
    public function index(): Response
    {
    return $this->render('ateliers/index.html.twig', [
    'controller_name' => 'AteliersController',
    ]);
    }
     */

}
