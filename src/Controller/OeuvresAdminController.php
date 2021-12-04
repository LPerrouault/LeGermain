<?php

namespace App\Controller;

use App\DataFixtures\SeachData;
use App\Entity\Oeuvre;
use App\Entity\Tag;
use App\Entity\Type;
use App\Form\OeuvreFormType;
use App\Repository\OeuvreRepository;
use App\Repository\TagRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class OeuvresAdminController extends AbstractController
{
    #[Route('/oeuvres_admin', name: 'oeuvres_admin')]
    public function index(OeuvreRepository $repository, Request $request): Response
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


        return $this->render('oeuvres_admin/index.html.twig', [
            'oeuvres' => $oeuvres,
            'tags' => $tagOeuvre,
            'types'=> $type
        ]);
    }

//  route permettant de visualiser l'article
    #[Route('/oeuvres_admin/{id}', name: 'oeuvres_admin_views')]
    public function affichageNews(int $id, OeuvreRepository $repository): Response{
        $oeuvres = $repository->find($id);

        return $this->render('oeuvres_admin/view.html.twig', [
            'oeuvres' => $oeuvres
        ]);
    }

//    route permettant la confirmation de la supression de l'article
    #[Route('/oeuvre_admin_remove/{id}', name: 'remove_oeuvre')]
    public function removeNews(int $id, Request $request, OeuvreRepository $repository, TagRepository $tagRepository): Response{
        $oeuvre = $repository->find($id);
        $tag = $tagRepository->searchTagOeuvre($oeuvre->getId());

        if ($oeuvre != null){
            $oeuvre->removeListeTag($tag[0]);
            $em = $this->getDoctrine()->getManager();
            $em->remove($oeuvre);
            $em->flush();
        }

        return $this->render('oeuvres_admin/remove.html.twig', [
            'oeuvres' => $oeuvre
        ]);
    }

//  route permettant l'ajout d'un article dans la base de donné et de upload le fichier associer
    #[Route('/oeuvre_admin_add', name: 'oeuvre_admin_add')]
    public function addNews(Request $request, TypeRepository $typeRepository, SluggerInterface $slugger): Response{
        $oeuvre= new Oeuvre();
        $tag = new Tag();

//      variable d'enregistreent de la date actuel
        $time = date('Y-m-d H:i:s', time());
        $date =new \DateTime();
        $date->format($time);

        $form = $this->createForm(OeuvreFormType::class, $oeuvre);
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

                $path = '/public/image/oeuvre/'.$newFilename;

                //verification si le fichier existe false on upload, true on fait rien
                if (!file_exists($path)){
                    try {
                        $brochureFile->move(
                            $this->getParameter('oeuvre_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) { $e = null; }
                }

                /*
                * Peparation de la requete pour la base de donnée
                */
                $oeuvre->setOeuvre(
                    $form->get('titre')->getData(),
                    $form->get('largeur')->getData(),
                    $form->get('hauteur')->getData(),
                    $newFilename,
                    $form->get('description')->getData(),
                    $form->get('idType')->getData(),
                    $date
                );
                //ajout de l'article avec le tag qui lui correspond
                $oeuvre->addListeTag($form->get('listeTags')->getData());

                //envoie de la requette pour ajouter le nouveau article
                $em = $this->getDoctrine()->getManager();
                $em->persist($oeuvre);
                $em->flush();

            }
            return $this->redirectToRoute('success_add');
        }

        return $this->render('oeuvres_admin/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //    Route permettant le modification d'un article
    #[Route('/oeuvre_admin_update/{id}', name: 'update_oeuvre')]
    public function updateNews(int $id,Request $request,SluggerInterface $slugger,TagRepository $tagRepository, OeuvreRepository $repository): Response{
        $oeuvre = $repository->find($id);
        $tag = new Tag();
       // dd($oeuvre);
//      initialisation des variable
        $form = $this->createForm(OeuvreFormType::class, $oeuvre);

        $form->get('titre')->setData($oeuvre->getTitre());
        $form->get('largeur')->setData($oeuvre->getLargeur());
        $form->get('hauteur')->setData($oeuvre->getHauteur());
        $form->get('description')->setData($oeuvre->getDescription());
        $form->get('idType')->setData($oeuvre->getIdType());

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

                $path = '/public/image/oeuvre/'.$newFilename;

                //verification si le fichier existe false on upload, true on fait rien
                if (!file_exists($path)){
                    try {
                        $brochureFile->move(
                            $this->getParameter('oeuvre_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) { $e = null; }
                }
                /*
               * Peparation de la requete pour la mise a jour dans la base de donnée
               */
                $oeuvre->setOeuvre(
                    $form->get('titre')->getData(),
                    $form->get('largeur')->getData(),
                    $form->get('hauteur')->getData(),
                    $newFilename,
                    $form->get('description')->getData(),
                    $form->get('idType')->getData(),
                    $oeuvre->getDatePublication()
                );
//              On enregistre dans le tag qui correspond a l'oeuvre
                $oldTag = $tagRepository->searchTagOeuvre($id);
//                Ajout de l'oeuvre avec le tag qui lui correspond.
//              Si on mofifie le tag alors on change la correspondance dans la table

                if ($oeuvre->getListeTags() != $form->get('listeTags')->getData()){
                    $oeuvre->removeListeTag($oldTag[0]);
                    $oeuvre->addListeTag($form->get('listeTags')->getData());
                }

                //envoie de la requette dans la base de donnée
                $em = $this->getDoctrine()->getManager();
                $em->persist($oeuvre);
                $em->flush();

                $this->redirectToRoute('success_add');
            }

        }

        return $this->render('oeuvres_admin/update.html.twig', [
            'oeuvres' => $oeuvre,
            'form' => $form->createView(),
        ]);
    }

// route succé creaton de l'article
    #[Route('/oeuvre_admin_add_success', name: 'success_add')]
    public function successAdd(): Response{
        return $this->render('oeuvres_admin/success_add.html.twig', [
        ]);
    }
}
