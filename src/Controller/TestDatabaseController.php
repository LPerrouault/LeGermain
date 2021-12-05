<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

use App\Entity\type;
use App\Entity\tag;
use App\Entity\Atelier;
use App\Entity\Article;
use App\Entity\Oeuvre;
use App\Entity\Utilisateur;
use App\Entity\Inscription;

class TestDatabaseController extends AbstractController {

    /**
     * @Route("/test/database", name="test_database")
     */
    public function index(): Response {
        $entityManager = $this->getDoctrine()->getManager();
        //Création des types
        $ty1 = new type();
        $ty1->setLibelle("Affiche");
        $ty2 = new type();
        $ty2->setLibelle("Illustration");
        $ty3 = new type();
        $ty3->setLibelle("Logo");
        //Test d'insertion de données dans la base de données
        $ty1Found = $this->getDoctrine()->getRepository(type::class)->findOneBy(['libelle' => 'Affiche']);
        if (!$ty1Found) {
            $entityManager->persist($ty1);
            $entityManager->persist($ty2);
            $entityManager->persist($ty3);
        }
        //Création des tags
        $ta1 = new tag();
        $ta1->setLibelle("atelier");
        $ta2 = new tag();
        $ta2->setLibelle("oeuvre");
        $ta3 = new tag();
        $ta3->setLibelle("news");
        $ta4 = new tag();
        $ta4->setLibelle("exposition");
        $ta5 = new tag();
        $ta5->setLibelle("commande");
        $ta6 = new tag();
        $ta6->setLibelle("monochrome");
        $ta7 = new tag();
        $ta7->setLibelle("couleur");
        $ta8 = new tag();
        $ta8->setLibelle("paysage");
        $ta9 = new tag();
        $ta9->setLibelle("transparent");
        $ta10 = new tag();
        $ta10->setLibelle("personnage");
        $ta11 = new tag();
        $ta11->setLibelle("portait");
        $ta12 = new tag();
        $ta12->setLibelle("décor");
        $ta13 = new tag();
        $ta13->setLibelle("carré");
        $ta14 = new tag();
        $ta14->setLibelle("petit");
        $ta15 = new tag();
        $ta15->setLibelle("moyen");
        $ta16 = new tag();
        $ta16->setLibelle("grand");
        $ta17 = new tag();
        $ta17->setLibelle("évènement");
        
        $ta1Found = $this->getDoctrine()->getRepository(tag::class)->findOneBy(['libelle' => 'atelier']);
        if (!$ta1Found) {
            //Persistance des tags
            $entityManager->persist($ta1);
            $entityManager->persist($ta2);
            $entityManager->persist($ta3);
            $entityManager->persist($ta4);
            $entityManager->persist($ta5);
            $entityManager->persist($ta6);
            $entityManager->persist($ta7);
            $entityManager->persist($ta8);
            $entityManager->persist($ta9);
            $entityManager->persist($ta10);
            $entityManager->persist($ta11);
            $entityManager->persist($ta12);
            $entityManager->persist($ta13);
            $entityManager->persist($ta14);
            $entityManager->persist($ta15);
            $entityManager->persist($ta16);
        }
        //Création des articles
        $date = new \DateTime('@'.strtotime('now'));
        $ar1 = new Article();
        $ar1->setArticle("Nouvelle attaque Artfight", $date->createFromFormat("d-m-Y", "30-07-2021"), 
                "https://images.artfight.net/attack/qJlofgviUCR9E44ddBlRH30Ejbc3hPnipFjPvG5Ix1tIHSR6NremPsK9bP4Y.png",
                "Nouvelle oeuvre (friendly fire) sur Artfight");
        $ar2 = new Article();
        $ar2->setArticle("Nouvelle attaque Artfight", $date->createFromFormat("d-m-Y", "30-07-2021"), 
                "https://images.artfight.net/attack/qJlofgviUCR9E44ddBlRH30Ejbc3hPnipFjPvG5Ix1tIHSR6NremPsK9bP4Y.png",
                "Nouvelle oeuvre (friendly fire) sur Artfight");
        $ar3 = new Article();
        $ar3->setArticle("Nouvelle attaque Artfight", $date->createFromFormat("d-m-Y", "30-07-2021"), 
                "https://images.artfight.net/attack/qJlofgviUCR9E44ddBlRH30Ejbc3hPnipFjPvG5Ix1tIHSR6NremPsK9bP4Y.png",
                "Nouvelle oeuvre (revenge) sur Artfight");
        $ar4 = new Article();
        $ar4->setArticle("Nouvelle attaque Artfight", $date->createFromFormat("d-m-Y", "17-07-2021"), 
                "https://images.artfight.net/attack/qJlofgviUCR9E44ddBlRH30Ejbc3hPnipFjPvG5Ix1tIHSR6NremPsK9bP4Y.png",
                "Nouvelle oeuvre (revenge) sur Artfight");
        
        //Ajout de tags aux articles
        $ar1->addListeTag($ta2);
        $ar1->addListeTag($ta17);
        $ar2->addListeTag($ta2);
        $ar2->addListeTag($ta17);
        $ar3->addListeTag($ta2);
        $ar3->addListeTag($ta17);
        $ar4->addListeTag($ta2);
        $ar4->addListeTag($ta17);
        
        $ar1Found = $this->getDoctrine()->getRepository(Article::class)->findOneBy(['id' => '1']);
        if (!$ar1Found) {
            //Persistance des articles
            $entityManager->persist($ar1);
            $entityManager->persist($ar2);
            $entityManager->persist($ar3);
            $entityManager->persist($ar4);
        }
        
        //Création des oeuvres
        $o1 = new Oeuvre();
        $o1->setOeuvre("He looks tired", 1080, 1080, 
                "https://images.artfight.net/attack/qJlofgviUCR9E44ddBlRH30Ejbc3hPnipFjPvG5Ix1tIHSR6NremPsK9bP4Y.png",
                "Une réalisation pour l'Artfight 2021, friendly fire sur Reinzu", $ty2);
        $o2 = new Oeuvre();
        $o2->setOeuvre("Colorful Hero", 1080, 1080, 
                "https://images.artfight.net/attack/Ct8ULX4gzIyCIFHa1JC783Ny1iihhzsleCwErc79kf5FbhrztZmXR2NfEzky.png?t=1627658398",
                "Une réalisation pour l'Artfight 2021, friendly fire sur SeaShellS", $ty2);
        $o3 = new Oeuvre();
        $o3->setOeuvre("Silence in the Winter Court", 1080, 1080, 
                "https://images.artfight.net/attack/qJlofgviUCR9E44ddBlRH30Ejbc3hPnipFjPvG5Ix1tIHSR6NremPsK9bP4Y.png",
                "Une réalisation pour l'Artfight 2021, revenge sur aetherwyn", $ty2);
        $o4 = new Oeuvre();
        $o4->setOeuvre("Colorful Hero", 1920, 1080, 
                "https://images.artfight.net/attack/Ct8ULX4gzIyCIFHa1JC783Ny1iihhzsleCwErc79kf5FbhrztZmXR2NfEzky.png?t=1627658398",
                "Une réalisation pour l'Artfight 2021, revenge sur InkyItsLeviosa", $ty2);
        //Association de tags aux oeuvres
        $o1->addListeTag($ta7);
        $o1->addListeTag($ta10);
        $o1->addListeTag($ta13);
        $o2->addListeTag($ta7);
        $o2->addListeTag($ta10);
        $o2->addListeTag($ta13);
        $o3->addListeTag($ta7);
        $o3->addListeTag($ta10);
        $o3->addListeTag($ta13);
        $o4->addListeTag($ta7);
        $o4->addListeTag($ta10);
        $o4->addListeTag($ta8);
        
        $o1Found = $this->getDoctrine()->getRepository(Oeuvre::class)->findOneBy(['id' => '1']);
        if (!$o1Found) {
            //Persistance des Oeuvres
            $entityManager->persist($o1);
            $entityManager->persist($o2);
            $entityManager->persist($o3);
            $entityManager->persist($o4);
        }
        
        //Création des ateliers
        $a1 = new Atelier();
        $a1->setAtelier("Premiers pas dans le monde de l'art", "Premiers essai aux dessin, création de paysages et premiers croquis", 
                $date->createFromFormat("d-m-Y", "26-04-2017"), 4, 22);
        $a2 = new Atelier();
        $a2->setAtelier("Paysages simplistes", "Analyse de paysage et retranscription des données", 
                $date->createFromFormat("d-m-Y", "13-05-2018"), 6, 16);
        
        //Création d'inscriptions
        $i1 = new Inscription();
        $i1->setInscription("nom", "prenom", "prenom.nom@gmail.com", '0602060206', null, $a1);
        $i2 = new Inscription();
        $i2->setInscription("test", "test", "test.test@gmail.com", '0602060202', "Je souhaite rejoindre cet atelier", $a1);
        
        //Création de l'utilisateur
        $u1 = new Utilisateur();
        $u1->setUtilisateur("epiccassouille", "testtest0", "Picassouille", "Eugénie");
        $u1->setRoles(["ROLE_ADMIN", "ROLE_USER"]);
        
        $a1Found = $this->getDoctrine()->getRepository(Atelier::class)->findOneBy(['id' => '1']);
        if (!$a1Found) {
            //Persistance des Oeuvres
            $entityManager->persist($a1);
            $entityManager->persist($a2);
            $entityManager->persist($i1);
            $entityManager->persist($i2);
            $entityManager->persist($u1);
        }
        
        try {
            //Insertion des données
            $entityManager->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage()." Ligne ".$e->getLine());
        }
        return $this->render('test_database/index.html.twig', [
                    'controller_name' => 'TestDatabaseController',
        ]);
    }

}
