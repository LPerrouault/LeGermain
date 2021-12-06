<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class DataBaseFunction{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function fetchingObject($repository, $data){
        $product = $this->em
            ->getRepository($repository)
            ->find($data);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$data
            );
        }
        return $product;
    }

    public function fetchingObjectAll($repository){
        $product = $this->em
            ->getRepository($repository)
            ->findAll();

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found yours request'
            );
        }
        return $product;
    }

    public function fetchingObjectBy($repository, $parameter1, $parameter2){
        $product = $this->em
            ->getRepository($repository)
            ->findBy([$parameter1],[$parameter2]);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found yours request'
            );
        }
        return $product;
    }

    public function updatingObject($repository, $dataID,$newValue, $route){
        $em = $this->getDoctrine()->em;
        $product =$em->getRepository($repository)->find($dataID);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$dataID
            );
        }

        $em->setName($newValue);
        $em->flush();

        return $this->redirectToRoute($route);
    }

    public function deletingObject($repository, $dataID, $newValue, $route){
        $em = $this->getDoctrine()->em;
        $product = $em->getRepository($repository)->find($dataID);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$dataID
            );
        }

        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute($route);
    }

    public function simpleQuery($resqSQL){
        return $this->getEntityManager()
            ->createQuery($resqSQL)
            ->getResult();
    }


}