<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\AtelierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;



class AteliersController extends AbstractController
{
    /**
     * Affichage de la page Ateliers
     * @return Response
     */
    #[Route('/ateliers', name: 'ateliers')]
    public function index(): Response{

        //récupère les données dans la base de données
        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $ateliers = $repo->findAll();

        //Affiche les données dans la page
        return $this->render('ateliers/index.html.twig', [
                'controller_name' => 'AteliersController',
                'ateliers' => $ateliers
        ]);
    }

    /**
     * Prend en paramètre l'id de l'Atelier et affiche les détails de l'atelier
     * @param $id
     * @return Response
     */
    #[Route('/ateliers/{id}', name: 'views_atelier')]
    public function ateliersDetails($id, AtelierRepository $repository): Response {
        //récupère les données depuis la base de données
        $atelier = $repository->find($id);

        //affiche les données dans la page
        return $this->render('ateliers/_view.html.twig', [
            'atelier' => $atelier
        ]);
    }


    /*
     * Vérification des données rentrer dans le formulaire
     * S'il y a une erreur renvoie un message
     */
    #[Route('ateliers/inscription/{id}', name: 'inscription_ateliers')]
    public function form_validation($id, Request $request,AtelierRepository $atelierRepository ): Response {

        //récupère les données depuis la base de données
        $atelier = $atelierRepository->find($id);
        $inscription = new Inscription();
        $error_message = null;

        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        //Récupération des réponses
        //rajouter l'id ausssi pour voir s'il c'est nécessaire
        $nom = $form->get('nom')->getData();
        $prenom = $form->get('prenom')->getData();
        $email = $form->get('email')->getData();
        $telephone = $form->get('telephone')->getData();
        $message = $form->get('message')->getData();

        //on verrifie que le fomulaire à bien été soumis
        if ($form->isSubmitted() && $form->isValid()){

            //Vérification des données avec check_data_form_inscription qui est déclarer en bas
            $error_message = $this->check_data_form_inscription($id, $nom, $prenom, $email, $telephone, $message);

            //on vérifie si il n'i a pas d'erreur
            if (empty($error_message)){
                //On insère les données dans la base de données
                $inscription->setInscription($nom,$prenom,$email,$telephone,$message,$atelier);
                $em = $this->getDoctrine()->getManager();
                $em->persist($inscription);
                $em->flush();

                return $this->redirectToRoute('success');
            }
        }
            //Affichage de la page contact avec render du formulaire
        return $this->renderForm('ateliers/inscription.html.twig',
            [
                'atelier' => $atelier,
                'form' => $form,
                'error' => $error_message,

            ]);
    }

    /**
     * Si les champs sont nulls, on renvoie un message d'erreur
     * @param $nom
     * @param $prenom
     * @param $email
     * @param $telephone
     * @param $message
     * @return string|null
     */
    public function check_data_form_inscription($nom, $prenom, $email, $telephone, $message) {
        $error = null;
        //Le message ne doit pas être null
        if (empty($message)) {
            $error = "Veuillez insérer le contenu de votre message";
        }
        //Le telephone ne doit pas être null
        if (empty($telephone) || $telephone =! 10) {
            $error = "Veuillez insérer un numéro de téléphone valide";
        }
        //L'email ne doit pas être null, et avoir une forme d'email
        if (empty($email) && filter_var($email)) {
            $error = "Veuillez insérer une adresse mail valide " .
                "(exemple : exemple@email.com)";
        }
        //Le prénom ne doit pas être null
        if (empty($prenom)) {
            $error = "Veuillez insérer un prénom";
        }
        //Le nom ne doit pas être null
        if (empty($nom)) {
            $error = "Veuillez insérer un nom";
        }
        return $error;
    }

    //route en cas de succes du formulaire
    #[Route('/ateliers/inscription-succes', name: 'success')]
    public function inscriptionSucces(): Response {
        return $this->render('ateliers/_succes.html.twig', [
        ]);
    }

}
