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
//       Initialisation du variable SearchDat qui stoque les tag des oeuvres
//        Puis on lui attribue la page 1 qui nous permet de mettre en place une pagination d
//          des oeuvre
        $data = new SeachData();
        $data->page = $request->get('page', 1);

//        Initialisation d'une variable $tag qui contient tous les tag present dans la BD.
//        Initialisation d'une variable $type qui contient tous les type d'oeuvre present dans la BD
        $tag = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $type = $this->getDoctrine()->getRepository(Type::class)->findAll();

//        On stoque les tag dans une array qui sont atribué a une oeuvre
//        L'array sera ensuite envoyé au twig pour affichage
        $tagOeuvre = [];
        foreach ($tag as $value){
            if (count($value->getListeOeuvres())>0){
                $tagOeuvre[] =$value;
            }
        }

//        On effectue un double filtrage par des requete SQL
//          * Si un tag et un type est selectionné alors on effectue une requette qui cherche les oeuvre qui on ce tag et ce type selectionés
//          * Si un tag est selectionné mais pas type alors on effectue une requette qui cherche les oeuvre qui on ce tag selectionné
//          * Si un type est selectionné mais pas tag alors on effectue une requette qui cherche les oeuvre qui on le type selectionné
//          *Sinon on affiche tous les oevres
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

//    Route qui permet d'aficher en gros l'oeuvre selectionne (avec toutes les informations)
    #[Route('/oeuvres/{id}', name: 'oeuvres_views')]
    public function affichageNews(int $id, OeuvreRepository $repository): Response{
        $oeuvres = $repository->find($id);

        return $this->render('oeuvres/view.html.twig', [
            'oeuvres' => $oeuvres
        ]);
    }
}
