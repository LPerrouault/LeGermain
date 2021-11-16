<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Entity\Tag;
use App\Entity\Type;
use App\Repository\OeuvreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OeuvresController extends AbstractController
{
    #[Route('/oeuvres', name: 'oeuvres')]
    public function index(OeuvreRepository $repository, Request $request): Response{
        $data = new SeachData();
        $data->page = $request->get('page', 1);

        $tag = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $type = $this->getDoctrine()->getRepository(Type::class)->findAll();

        $tagOeuvre = [];

        foreach ($tag as $tag){
            if (count($tag->getListeOeuvres())>0){
                $tagOeuvre[] =$tag;
            }
        }


        if (!empty($request->query->get('searchTag')) && !empty($request->query->get('searchType'))){
            $oeuvres = $repository->findSearchTagAndType($request, $data);
        }
        elseif (!empty($request->query->get('searchTag')) && empty($request->query->get('searchType'))){
            $oeuvres = $repository->findSearchTag($request, $data);
        }
        elseif (empty($request->query->get('searchTag')) && !empty($request->query->get('searchType'))){
            $oeuvres = $repository->findSearchType($request, $data);
        }
        else{
            $oeuvres = $repository->findSearchFilter($data);
        }


        return $this->render('oeuvres/index.html.twig', [
            'oeuvres' => $oeuvres,
            'tags' => $tagOeuvre,
            'types'=> $type
        ]);
    }

    #[Route('/oeuvres/{id}', name: 'oeuvres_views')]
    public function affichageNews(int $id, OeuvreRepository $repository): Response{
        $oeuvres = $repository->find($id);

        return $this->render('oeuvres/view.html.twig', [
            'oeuvres' => $oeuvres
        ]);
    }
}
