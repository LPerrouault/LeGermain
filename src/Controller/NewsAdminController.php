<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Form\AddArticleFormType;
use App\Entity\Article;
use App\Entity\Tag;
use App\Repository\ArticlesRepository;
use App\Repository\TagRepository;
use App\Service\FilUploader;
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
//       Initialisation du variable SearchDat qui stoque les tag des article
//        Puis on lui attribue la page 1 qui nous permet de mettre en place une pagination d
//          des articles
        $data = new SeachData();
        $data->page = $request->get('page', 1);

//        Initialisation d'une variable tag qui contient tous les tag present dans la BD
//         que l'on stoque dans une array en verrifiant que chaque tag present dans la varriable
//        tag contient à un article attribué.
//        L'array sera ensuite envoyé au twig pour affichage
        $tag = $this->getDoctrine()->getRepository(Tag::class)->findAll();
        $tagArticle = [];
        foreach ($tag as $value){
            if (count($value->getListeArticles())>0){
                $tagArticle[] =$value;
            }
        }

//        On recuperre le nom du tag qui a ete selectionné dans le filtre
        $filterTag = $request->query->get('searchTag');
//        Si la valeur est null on effectue une requette qui affiche tous les article.
//        Sinon on effectue une requette qui affiche les article avec e tag selestionne
        if ($filterTag == null){
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

//  route permettant de visualiser l'article
    #[Route('/news_admin/{id}', name: 'news_admin_views')]
    public function affichageNews(int $id, ArticlesRepository $repository): Response{
        $article = $repository->find($id);
        return $this->render('news_admin/view.html.twig', [
            'article' => $article
        ]);
    }

//    route permettant la confirmation de la supression de l'article
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
    public function updateNews(int $id,Request $request,SluggerInterface $slugger,TagRepository $tagRepository, ArticlesRepository $repository): Response{
        $article = $repository->find($id);
        $newArticle = new Article();
        $newTag = new Tag();
        $tag = $tagRepository->searchTag($id);

//      initialisation de la variable date avec l'heur actuel
        $time = date('Y-m-d H:i:s', time());
        $date =new \DateTime();
        $date->format($time);
        $form = $this->createForm(AddArticleFormType::class, $article);
        $form->get('titre')->setData($article->getTitre());
        $form->get('listeTags')->setData($tag[0]);
        $form->get('corpsArticle')->setData($article->getCorpsArticle()) ;

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

                //verification si le fichier existe false on upload, true on fait rien
                if (!file_exists($path)){
                    try {
                        $brochureFile->move(
                            $this->getParameter('brochures_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) { $e = null; }
                }

            }
            $repository->updateArticle($id,$form->get('titre')->getData(),$newFilename, $form->get('corpsArticle')->getData());
        }

        return $this->render('news_admin/update.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

//  route permettant l'ajout d'un article dans la base de donné et de upload le fichier associer
    #[Route('/news_admin_add', name: 'news_admin_add')]
    public function addNews(Request $request, SluggerInterface $slugger): Response{
        $article = new Article();
        $tag = new Tag();
//      initialisation de la variable date avec l'heur actuel
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

                    //verification si le fichier existe false on upload, true on fait rien
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

// route succé creaton de l'article
    #[Route('/news_admin_add_success', name: 'success_add')]
    public function successAdd(ArticlesRepository $repository): Response{
        return $this->render('news_admin/success_add.html.twig', [
        ]);
    }
}
