<?php

namespace App\Controller;

use App\Entity\Atelier;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
    #[Route('/ateliers/{id}', name: 'ateliers_details')]
    public function ateliersDetails($id): Response {

        //récupère les données depuis la base de données
        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $atelier = $repo->find($id);

        //affiche les données dans la page
        return $this->render('ateliers/details.html.twig', [
            'atelier' => $atelier
        ]);
    }

    /**
     * Affiche la page d'inscription pour l'atelier en question
     * et la création du formulaire
     * @param $id
     * @return Response
     */
    #[Route('/ateliers/inscription/{id}', name: 'ateliers_inscription')]
    public function ateliersInscription($id) : Response {

        //récupère les données depuis la base de données
        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $atelier = $repo->find($id);

        /*$reposi = $this->getDoctrine()->getRepository(Inscription::class);
        $inscription = $reposi->findAll();*/

        //création du formulaire pour l'inscription à l'atelier
        $form = AteliersController::getInscriptionForm($atelier);

        //affichage de la page d'inscription avec render du formulaire
        return $this->render('ateliers/inscription.html.twig', [
            'atelier' => $atelier,
            //'inscription' => $inscription,
            'form' => $form->createView()
        ]);
    }

    /*public function new(Request $request): Response
    {
        $inscription = new Inscription;
        $formInscription = $this->createForm(InscriptionType::class, $inscription);
        return $this->render('ateliers/inscription.html.twig', [
            'form' => $formInscription->createView()
        ]);
    }*/


    /*
     * Vérification des données rentrer dans le formulaire
     * S'il y a une erreur renvoie un message
     */
    #[Route('ateliers/inscription/{id}', name: 'inscription_ateliers')]
    public function form_validation(Request $request, $id): Response {

        //récupère les données depuis la base de données
        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $atelier = $repo->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        //Récupération des réponses
        //rajouter l'id ausssi pour voir s'il c'est nécessaire
     //   $id = $request->get('form'["id_atelier_id"]);
        $nom = $request->get('form')["nom"];
        $prenom = $request->get('form')["prenom"];
        $email = $request->get('form')["email"];
        $telephone = $request->get('form')["telephone"];
        $message = $request->get('form')["message"];

        //Vérification serveur des données
        $error_message = $this->check_data_form_inscription(/*$id,*/ $nom, $prenom, $email, $telephone, $message);
        //S'il n'y a pas de message d'erreur retourné lors de la vérification
        if ($error_message == null) {
            //On insère les données dans la base de données
            $message_complet = new Inscription();
            $message_complet->setInscription(/*$id,*/ $nom, $prenom, $email, $telephone, $message);
            $entityManager->persist($message_complet);
            try {
                //Insertion des données
                $entityManager->flush();
                //Affichage de la page de succès avec objet Inscription créé
                return $this->render('ateliers/inscription_succes.html.twig', [
                    'controller_name' => 'AteliersController',
                    'inscription' => $message_complet,
                ]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage() . " Ligne " . $e->getLine());
            }
        }
        //Sinon, il y a une erreur, retourner sur page précédente, garder les
        //données saisies et l'afficher
        else {
            //Création du formulaire de contact
            $form = AteliersController::getInscriptionForm();
            //Affichage de la page contact avec render du formulaire
            return $this->renderForm('ateliers/inscription.html.twig',
                [
                    'atelier' => $atelier,
                    'form' => $form,
                    'error' => $error_message,
              //      'id' => $id,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'telephone' => $telephone,
                    'contenu' => $message,
            ]);
        }
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
        if (empty($telephone)) {
            $error = "Veuillez insérer un numéro de téléphone";
        }
        //L'email ne doit pas être null, et avoir une forme d'email
        if (empty($email) && filter_var($email)) {
            $error = "Veuillez insérer une adresse mail valide " .
                "(exemple : test@gmail.com)";
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

    /**
     * Retourne le formulaire de contact
     * @param Atelier|null $atelier (l'id de l'atelier)
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getInscriptionForm(?atelier $atelier) {

        $inscription = new Inscription();
        $inscription->setIdAtelier($atelier);

        return $this->createFormBuilder($inscription)
            //Essai de mettre le champ hidden (et non type car il n'y a pas d'utilisation de Form\Type pour l'id avec le 'hidden-row'
            ->add('id', NumberType::class, array(
                'attr' => array('class' => 'hidden-row')))
            ->add('nom', TextType::class, array('required' => false))
            ->add('prenom', TextType::class, array('required' => false))
            ->add('email', EmailType::class, array('required' => false))
            ->add('telephone', TelType::class, array('required' => false))
            ->add('message', TextareaType::class, array('required' => false))
            ->add('reset', ResetType::class, array(
                'attr' => array('class' => 'save')))
            ->add('save', SubmitType::class, ['label' => 'Envoyer'])
        //    ->setAction($this->generateUrl('ateliers'))
            ->setAction($this->generateUrl('inscription_ateliers'))
            ->getForm();

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
