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
     * Affichage de la page Ateliers avec tous les ateliers
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
     * Prend en paramètre l'id de l'Atelier et affiche les détails de l'atelier selectionné
     * @param $id
     * @return Response
     */
    #[Route('/ateliers/{id}', name: 'ateliers_details')]
    public function ateliersDetails($id): Response {

        //récupère les données de l'id mis en paramètre depuis la base de données
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

        //récupère les données de l'id mis en paramètre depuis la base de données
        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $atelier = $repo->find($id);

        //création du formulaire pour l'inscription à l'atelier avec la méthode getInscriptionForm (qui est plus bas dans le code)
        $form = AteliersController::getInscriptionForm($atelier);

        //affichage de la page d'inscription avec render du formulaire
        return $this->render('ateliers/inscription.html.twig', [
            'atelier' => $atelier,
            'form' => $form->createView()
        ]);
    }

    //Ici le premier essai de la création du formulaire avec le Form\Type mais non utilisé au final
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
    #[Route('ateliers/inscription', name: 'inscription_ateliers')]
    public function form_validation(Request $request, $id): Response {

        //récupère les données de l'id mis en paramètre depuis la base de données
        $repo = $this->getDoctrine()->getRepository(Atelier::class);
        $atelier = $repo->find($id);

        //prend les données
        $entityManager = $this->getDoctrine()->getManager();

        //Récupération des réponses
        //la variable pour récuperer l'id de l'atelier est mis en commentaire car pour le moment
        //je ne vois pas comment l'utiliser
    //    $id = $request->get('form'["id_atelier_id"]);
        $nom = $request->get('form')["nom"];
        $prenom = $request->get('form')["prenom"];
        $email = $request->get('form')["email"];
        $telephone = $request->get('form')["telephone"];
        $message = $request->get('form')["message"];

        //Vérification serveur des données avec check_data_form_inscription qui est déclarer en bas
        $error_message = $this->check_data_form_inscription($id, $nom, $prenom, $email, $telephone, $message);
        //S'il n'y a pas de message d'erreur retourné lors de la vérification
        if ($error_message == null) {
            //On insère les données dans la base de données
            $message_complet = new Inscription();
            $message_complet->setInscription($id, $nom, $prenom, $email, $telephone, $message);
            $entityManager->persist($message_complet);
            try {
                //Insertion des données
                $entityManager->flush();
                //Affichage de la page de succès avec objet Inscription créé
                return $this->render('ateliers/inscription_succes.html.twig', [
                    'controller_name' => 'AteliersController',
                    'inscription' => $message_complet->getId(),
                ]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage() . " Ligne " . $e->getLine());
            }
        }
        //Sinon, il y a une erreur, retourner sur page précédente, garder les
        //données saisies et l'afficher
        else {
            //Création du formulaire de l'atelier avec la méthode getInscriptionForm
            $form = AteliersController::getInscriptionForm($atelier);
            //Affichage de la page contact avec render du formulaire
            return $this->renderForm('ateliers/inscription.html.twig',
                [
                    'atelier' => $atelier,
                    'form' => $form,
                    'error' => $error_message,
                    'id' => $id,
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
     * Retourne le formulaire de l'atelier
     * @param Atelier|null $atelier (l'id de l'atelier)
     * @return \Symfony\Component\Form\FormInterface
     */
    //la fonction a pris en paramètre l'id de l'atelier provenant de App\Entity\Atelier
    public function getInscriptionForm(?atelier $atelier) {

        $inscription = new Inscription();
        //ici la variable inscription prend donc l'id de l'atelier pour l'inscription en question
        //la méthode setIdAtelier provient de App\Entity\Inscription
        $inscription->setIdAtelier($atelier);

        //retourne la création du formulaire de l'atelier
        return $this->createFormBuilder($inscription)
            // rajout de l'id est en commentaire, je ne sais pas toujours pas s'il est nécessaire ou non
            //    ->add('id', NumberType::class, array('required' => false))
            ->add('nom', TextType::class, array('required' => false))
            ->add('prenom', TextType::class, array('required' => false))
            ->add('email', EmailType::class, array('required' => false))
            ->add('telephone', TelType::class, array('required' => false))
            ->add('message', TextareaType::class, array('required' => false))
            ->add('reset', ResetType::class, array(
                'attr' => array('class' => 'save')))
            ->add('save', SubmitType::class, ['label' => 'Envoyer'])
            //ici je retourne à la page 'ateliers' quand on appuie sur Envoyer
            ->setAction($this->generateUrl('ateliers'))
            //car avec l'action juste en dessus, on obtient l'erreur de l'id manquant
            //pour la page des inscriptions ('inscription_ateliers' est la route pour la méthode :
            // public function form_validation()
        //  ->setAction($this->generateUrl('inscription_ateliers'))
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