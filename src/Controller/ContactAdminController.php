<?php

namespace App\Controller;

use App\Entity\MailContact;
use App\Repository\MailContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class ContactAdminController extends AbstractController
{
    #[Route('admin/contact_admin', name: 'contact_admin')]
    public function index(MailContactRepository $contactRepository, Request $request): Response
    {
        // filtre enregistrement des valeur des bouton dans une varriable
        $filter = $request->query->keys();

        //affichage des differentes categorie du filtre
        //1- affichage de tous les messages
        //2- affichage des messages deja repondu
        //3- affichag des messages non repondu
        //reponseContact voir fin de page
        if ($filter[0] == 'all'){
            $contacts = $contactRepository->orderByAll();
            $this->reponseContact($request, $contactRepository);
        }elseif ($filter[0]  == 'reply'){
            $contacts = $contactRepository->orderByReply();
        }elseif ($filter[0]  = 'waiting'){
            $contacts = $contactRepository->orderByWait();
            $this->reponseContact($request, $contactRepository);
        }else{
            $contacts = $contactRepository->orderByAll();
        }

        return $this->render('contact_admin/index.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    //route pour l'apercue du message sélectionné
    #[Route('admin/contact_admin_view/{id}', name: 'contact_admin_view')]
    public function view(int $id, MailContactRepository $contactRepository): Response
    {
        //on afficge le message par l'id du message sélectionner
        $contacts = $contactRepository->find($id);
        return $this->render('contact_admin/_view.html.twig', [
            'contacts' => $contacts,
        ]);
    }
    //route pour la supresion du message sélectionné
    #[Route('admin/contact_admin_remove/{id}', name: 'contact_admin_remove')]
    public function remove(int $id, MailContactRepository $contactRepository): Response
    {
        //on supprime le message par l'id du message sélectionner
        $contacts = $contactRepository->find($id);
        if ($contacts != null){
            $em = $this->getDoctrine()->getManager();
            $em->remove($contacts);
            $em->flush();
        }

        return $this->render('contact_admin/remove.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    //fonction permetant l'affichage si un message est repondue ou non
    public function reponseContact( Request $request, MailContactRepository $contactRepository){

        //mssage non repondu
        //on stoque le non du bouton dans une varriable
        //puis par l'id du message selectionner on met le champ reponse
        // de la base a 1
        if ($request->query->get('noReponse')){
            $noRepond = $request->query->get('noReponse');
            $valueNoRep = array_keys($noRepond);
            $mailContact = $contactRepository->find($valueNoRep[0]);
            if ( $valueNoRep[0] == $mailContact->getId()){
                $mailContact->setRepondu();
                $em = $this->getDoctrine()->getManager();
                $em->persist($mailContact);
                $em->flush();

                $this->redirectToRoute('contact_admin');
            }
        }
        //mssage  repondu
        //on stoque le non du bouton dans une varriable
        //puis par l'id du message selectionner on met le champ reponse
        // de la base a 0
        if ($request->query->get('Repondu')){
            $Repondu = $request->query->get('Repondu');
            $valueRep = array_keys($Repondu);
            $mailContact = $contactRepository->find($valueRep[0]);
            if ( $valueRep[0] == $mailContact->getId()){
                $mailContact->setARepondre();
                $em = $this->getDoctrine()->getManager();
                $em->persist($mailContact);
                $em->flush();
                $this->redirectToRoute('contact_admin');
            }
        }
    }
}
