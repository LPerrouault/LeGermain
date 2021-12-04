<?php

namespace App\Entity;

use App\Repository\MailContactRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MailContactRepository::class)
 */
class MailContact
{
    /**
     * Propriétés privées
     */
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sujet;

    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reponse;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_contacts;
    
    /**
     * Accesseurs (get/set)
     */

    /**
     * Retourne l'id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retourne le nom
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * Modifie le nom
     * @param string $nom
     * @return \self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Retourne le prénom
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * Modifie le prénom
     * @param string $prenom
     * @return \self
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Retourne l'email
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Modifie l'email
     * @param string $email
     * @return \self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Retourne le sujet
     * @return string|null
     */
    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    /**
     * Modifie le sujet
     * @param string $sujet
     * @return \self
     */
    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    /**
     * Retourne le contenu
     * @return string|null
     */
    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    /**
     * Modifie le contenu
     * @param string $contenu
     * @return \self
     */
    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Retourne la réponse
     * @return bool|null
     */
    public function getReponse(): ?bool
    {
        return $this->reponse;
    }

    /**
     * Modifie la réponse
     * @param bool $reponse
     * @return \self
     */
    public function setReponse(bool $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }
    public function getDateContacts(): ?\DateTimeInterface
    {
        return $this->date_contacts;
    }

    public function setDateContacts(\DateTimeInterface $date_contacts): self
    {
        $this->date_contacts = $date_contacts;

        return $this;
    }


    /**
     * Méthodes
     */
    
    /**
     * La demande de contact doit être répondue
     */
    public function setARepondre(){
        $this->setReponse(0);
    }
    /**
     * La demande de contact a reçu une réponse
     */
    public function setRepondu(){
        $this->setReponse(1);
    }

    
    public function setMailContact($nom, $prenom, $email, $sujet, $contenu, $date_contacts){
       $this->nom = $nom;
       $this->prenom = $prenom;
       $this->email = $email;
       $this->sujet = $sujet;
       $this->contenu = $contenu;
       $this->date_contacts = $date_contacts;
       $this->setARepondre();
    }



}
