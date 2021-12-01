<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Form\AddArticleFormType;
use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticlesRepository;
use App\Repository\TagRepository;
use App\Service\FilUploader;
use phpDocumentor\Reflection\Types\This;
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

    #[Route('/news_admin_remove/{id}', name: 'remove_news')]
    public function removeNews(int $id, Request $request, ArticlesRepository $repository, TagRepository $tagRepository): Response{
        $article = $repository->find($id);
        $tag = $tagRepository->searchTag($article->getId());

          if ($article != null){
              $article->removeListeTag($tag[0]);
              $em = $this->getDoctrine()->getManager();
              $em->remove($article);
              $em->flush();
          }

        return $this->render('news_admin/remove.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/news_admin_update/{id}', name: 'update_news')]
    public function updateNews(int $id, ArticlesRepository $repository): Response{
        $article = $repository->find($id);

        return $this->render('news_admin/remove.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/news_admin_add', name: 'news_admin_add')]
    public function addNews(Request $request, SluggerInterface $slugger): Response{
        $article = new Article();
        $tag = new Tag();
        //initialisation de la variable date avec l'heur actuel
        $time = date('Y-m-d H:i:s', time());
        $date =new \DateTime();
        $date->format($time);


        $form = $this->createForm(AddArticleFormType::class, $article);
        $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()){
                /** @var UploadedFile $brochureFile */
                $brochureFile = $form->get('nomFichierImage')->getData();
              // Cette condition est nécessaire parce que le champ "brochure" n'est pas obligatoire.
              // le fichier  doit donc être traité uniquement lorsqu'un fichier est upload.
                if ($brochureFile) {
                    $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename .'.' . $brochureFile->guessExtension();

                    $path = '/public/image/article/'.$newFilename;

                    //verification si le fichier existe false -> upload true on fait rien
                    if (!file_exists($path)){
                        try {
                            $brochureFile->move(
                                $this->getParameter('brochures_directory'),
                                $newFilename
                            );
                        } catch (FileException $e) { $e = null; }
                    }

                    /*
                    * Peparation de la requete pour la base de donnée
                         */
                    $article->setArticle(
                        $form->get('titre')->getData(),
                        $date,
                        $newFilename,
                        $form->get('corpsArticle')->getData(),
                    );
                    //ajout de l'article avec le tag qui lui correspond
                    $tag->setLibelle($form->get('listeTags')->getData());
                    $article->addListeTag($tag);

                    //envoie de la requette pour ajouter le nouveau article
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($article);
                    $em->flush();

                }
              return $this->redirectToRoute('success_add');
          }

        return $this->render('news_admin/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/news_admin_add_success', name: 'success_add')]
    public function successAdd(ArticlesRepository $repository): Response{
        return $this->render('news_admin/success_add.html.twig', [
        ]);
    }
}
