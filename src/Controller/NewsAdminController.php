<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Form\AddArticleFormType;
use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticlesRepository;
use App\Service\FilUploader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class NewsAdminController extends AbstractController
{
    #[Route('/news_admin', name: 'news_admin')]
    public function index(ArticlesRepository $articlesRepository, Request $request): Response
    {
        $data = new SeachData();
        $data->page = $request->get('page', 1);

        //dd($request->query);
        $tag = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $tagArticle = [];
        foreach ($tag as $tag){
            if (count($tag->getListeArticles())>0){
                $tagArticle[] =$tag;
            }
        }

        $countTag = $request->query->get('searchTag');

        if ($countTag == null){
            $articles = $articlesRepository->findSearchFilter($data);
        }
        else{
            $articles = $articlesRepository->findSearchAfterFilter($request, $data);
        }


        return $this->render('news_admin/index.html.twig', [
            'articles' => $articles,
            'tags' => $tagArticle
        ]);
    }

    #[Route('/news_admin/{id}', name: 'news_admin_views')]
    public function affichageNews(int $id, ArticlesRepository $repository): Response{
        $article = $repository->find($id);

        return $this->render('news_admin/view.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/news_admin_add', name: 'news_admin_add')]
    public function addNews(Request $request, ArticlesRepository $repository, SluggerInterface $slugger): Response{
        $article = new Article();
        $form = $this->createForm(AddArticleFormType::class, $article);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()){

//                /** @var UploadedFile $brochureFile */
//                $brochureFile = $form->get('nomFichierImage')->getData();
//
//                // this condition is needed because the 'brochure' field is not required
//                // so the PDF file must be processed only when a file is uploaded
//                if ($brochureFile) {
//                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
//                    // this is needed to safely include the file name as part of the URL
//                    $safeFilename = $slugger->slug($originalFilename);
//                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $brochureFile->guessExtension();
//
//                    // Move the file to the directory where brochures are stored
//                    try {
//                        $brochureFile->move(
//                            $this->getParameter('brochures_directory'),
//                            $newFilename
//                        );
//                    } catch (FileException $e) { $e = null; }
//
//                    $repository->addArticle($request, $form->get('titre')->getData(),$form->get('nomFichierImage')->getData(),$form->get('corpsArticle')->getData());

//                }
//           }
              return $this->redirectToRoute('success_add');
       }

        return $this->render('news_admin/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/news_admin_add_success', name: 'success_add')]
    public function successAdd(int $id, ArticlesRepository $repository): Response{
        return $this->render('news_admin/success_add.html.twig', [
        ]);
    }
}
