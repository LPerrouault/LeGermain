<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\MailContact;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactController extends AbstractController
{
    /**
     * Affiche la page de contact
     */
    #[Route('/contact', name: 'contact')]
    public function index(): Response
    {
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
                /*->setAction($this->generateUrl('envoi_contact'))*/
                ->getForm();
        //Affichage de la page contact avec render du formulaire
        return $this->renderForm('contact/index.html.twig',
                ['form' => $form]);
    }
}
