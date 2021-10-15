<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

use App\Entity\Type;
use App\Entity\Tag;


class TestDatabaseController extends AbstractController {

    /**
     * @Route("/test/database", name="test_database")
     */
    public function index(): Response {
        $entityManager = $this->getDoctrine()->getManager();
        //Création des types
        $ty1 = new Type();
        $ty1->setLibelle("Affiche");
        $ty2 = new Type();
        $ty2->setLibelle("Illustration");
        $ty3 = new Type();
        $ty3->setLibelle("Logo");
        //Test d'insertion de données dans la base de données
        $ty1Found = $this->getDoctrine()->getRepository(Type::class)->findOneBy(['libelle' => 'Affiche']);
        if (!$ty1Found) {
            $entityManager->persist($ty1);
            $entityManager->persist($ty2);
            $entityManager->persist($ty3);
            
            $entityManager->flush();
        }
        else {
            throw new Exception("Les données des types ont déjà été insérées");
        }
        //Création des tags
        /*$ta1 = new Tag();
        $ta1->setLibelle("atelier");
        $ta2 = new Tag();
        $ta2->setLibelle("oeuvre");
        $ta3 = new Tag();
        $ta3->setLibelle("news");
        $ta4 = new Tag();
        $ta4->setLibelle("exposition");
        $ta5 = new Tag();
        $ta5->setLibelle("commande");
        $ta6 = new Tag();
        $ta6->setLibelle("monochrome");
        $ta7 = new Tag();
        $ta7->setLibelle("couleur");
        $ta8 = new Tag();
        $ta8->setLibelle("paysage");
        $ta9 = new Tag();
        $ta9->setLibelle("transparent");
        $ta10 = new Tag();
        $ta10->setLibelle("personnage");
        $ta11 = new Tag();
        $ta11->setLibelle("portait");
        $ta12 = new Tag();
        $ta12->setLibelle("décor");
        $ta13 = new Tag();
        $ta13->setLibelle("carré");
        $ta14 = new Tag();
        $ta14->setLibelle("petit");
        $ta15 = new Tag();
        $ta15->setLibelle("moyen");
        $ta16 = new Tag();
        $ta16->setLibelle("grand");
        //Création des articles
        //Création des oeuvres
        //Création des ateliers
        //Création d'inscriptions
        //Création de l'utilisateur
        try {
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
            
            $entityManager->flush();
        } catch (Exception $e) {
            throw new ErrorException("Les données n'ont pas pu être insérées", 0);
        }*/
        return $this->render('test_database/index.html.twig', [
                    'controller_name' => 'TestDatabaseController',
        ]);
    }

}
