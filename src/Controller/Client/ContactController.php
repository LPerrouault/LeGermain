<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MailContact;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

//use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ContactController extends AbstractController {

    /**
     * Affiche la page de contact
     */
    #[Route('/contact', name: 'contact')]
    public function index(): Response {
        //Création du formulaire de contact
        $form = ContactController::getContactForm();
        //Affichage de la page contact avec render du formulaire
        return $this->renderForm('client/contact/index.html.twig',
                        ['form' => $form]);
    }

    /**
     * Après saisie des données, vérification de celle-ci
     * Si aucune erreur, insertion de la demande dans la base de données
     * Sinon,
     */
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
        //S'il n'y a pas de message d'erreur retourné lors de la vérification
        if ($error_message == null) {
            //On insère les données dans la base de données
            $message_complet = new MailContact();
            $message_complet->setMailContact($nom, $prenom, $email, $sujet, $contenu);
            $entityManager->persist($message_complet);
            try {
                //Insertion des données
                $entityManager->flush();
                //Affichage de la page de succès avec objet MailContact créé
                return $this->render('client/contact/succes_envoi.html.twig', [
                            'controller_name' => 'TestController',
                            'mailcontact' => $message_complet,
                ]);
            } catch (Exception $e) {
                throw new Exception($e->getMessage() . " Ligne " . $e->getLine());
            }
        }
        //Sinon, il y a une erreur, retourner sur page précédente, garder les
        //données saisies et l'afficher
        else {
            //Création du formulaire de contact
            $form = ContactController::getContactForm();
            //Affichage de la page contact avec render du formulaire
            //Les données déjà saisies sont réinsérées dans le formulaire
            return $this->renderForm('client/contact/index.html.twig',
                            ['form' => $form,
                                'error' => $error_message,
                                'nom' => $nom,
                                'prenom' => $prenom,
                                'email' => $email,
                                'sujet' => $contenu,
                                'contenu' => $contenu,
            ]);
        }
    }

    /**
     * 
     * @param type $nom Le nom du client
     * @param type $prenom Le prenom du client
     * @param type $email L'email à laquelle recontacter le client
     * @param type $sujet Le sujet du message
     * @param type $contenu Le contenu du message
     * @return string|null Retourne null si aucune erreur n'est détectée, ou 
     * le message correspondant à la dernière erreur trouvée (la plus haute
     * sur le formulaire)
     */
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

    /**
     * Retourne le formulaire de contact
     * @return FormBuilder Le formulaire de contact
     */
    public function getContactForm() {
        $contactMail = new MailContact();
        $contactMail->setARepondre();
        return $this->createFormBuilder($contactMail)
                        ->add('nom', TextType::class, array('required' => false))
                        ->add('prenom', TextType::class, array('required' => false))
                        ->add('email', EmailType::class, array('required' => false))
                        ->add('sujet', TextType::class, array('required' => false))
                        ->add('contenu', TextareaType::class, array('required' => false))
                        /* ->add('contenu', CKEditorType::class, array(
                          'config' => array(
                          'uiColor' => '#ffffff',
                          'toolbar' => 'standard'))) */
                        ->add('reset', ResetType::class, array(
                            'attr' => array('class' => 'save')))
                        ->add('save', SubmitType::class, ['label' => 'Envoyer'])
                        ->setAction($this->generateUrl('contact_envoi'))
                        ->getForm();
    }

}
