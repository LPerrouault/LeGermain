<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MailContact;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactController extends AbstractController {

    /**
     * Affiche la page de contact
     */
    #[Route('/contact', name: 'contact')]
    public function index(): Response {
        //Création du formulaire de contact
        $contactMail = new MailContact();
        $contactMail->setARepondre();
        $form = $this->createFormBuilder($contactMail)
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('email', EmailType::class)
                ->add('sujet', TextType::class)
                ->add('contenu', TextareaType::class, array(
                    'attr' => array('class' => 'tinymce')))
                ->add('reset', ResetType::class, array(
                    'attr' => array('class' => 'save')))
                ->add('save', SubmitType::class, ['label' => 'Envoyer'])
                ->setAction($this->generateUrl('contact_envoi'))
                ->getForm();
        //Affichage de la page contact avec render du formulaire
        return $this->renderForm('contact/index.html.twig',
                        ['form' => $form]);
    }

    #[Route('contact/envoi', name: 'contact_envoi')]

    public function form_validation(Request $request): Response {
        $entityManager = $this->getDoctrine()->getManager();
        //Récupération des réponses
        $nom = $request->get('form')["nom"];
        $prenom = $request->get('form')["prenom"];
        $email = $request->get('form')["email"];
        $sujet = $request->get('form')["sujet"];
        $contenu = $request->get('form')["contenu"];

        //Vérification serveur des données
        $error_message = $this->check_data_formcontact($nom, $prenom, $email, $sujet, $contenu);
        //S'il n'y a pas de message d'erreur retourné
        if ($error_message == null) {
            //On insère les données dans la base de données
            $message_complet = new MailContact();
            $message_complet->setMailContact($nom, $prenom, $email, $sujet, $contenu);
            $entityManager->persist($message_complet);
            try {
                //Insertion des données
                $entityManager->flush();
                echo "Succès de l'insertion";
            } catch (Exception $e) {
                throw new Exception($e->getMessage() . " Ligne " . $e->getLine());
            }
        }
        //Sinon, il y a une erreur, l'afficher
        else {
            
        }

        //Brouillon
        //Création du formulaire de contact
        $contactMail = new MailContact();
        $contactMail->setARepondre();
        $form = $this->createFormBuilder($contactMail)
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('email', EmailType::class)
                ->add('sujet', TextType::class)
                ->add('contenu', TextareaType::class, array(
                    'attr' => array('class' => 'tinymce')))
                ->add('reset', ResetType::class, array(
                    'attr' => array('class' => 'save')))
                ->add('save', SubmitType::class, ['label' => 'Envoyer'])
                ->setAction($this->generateUrl('contact_envoi'))
                ->getForm();
        //Affichage de la page contact avec render du formulaire
        return $this->renderForm('contact/index.html.twig',
                        ['form' => $form]);
    }

    public function check_data_formcontact($nom, $prenom, $email, $sujet, $contenu) {
        $error = null;
        //Le contenu ne doit pas être null
        if (empty($contenu)) {
            $error = "Veuillez insérer le contenu de votre message";
        }
        //Le sujet ne doit pas être null
        if (empty($sujet)) {
            $error = "Veuillez insérer un sujet pour votre message";
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

}
