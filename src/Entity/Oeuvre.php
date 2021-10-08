<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OeuvreRepository::class)
 */
class Oeuvre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     */
    private $largeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $hauteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomFichierImage;

    /**
     * @ORM\ManyToOne(targetEntity=type::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLargeur(): ?int
    {
        return $this->largeur;
    }

    public function setLargeur(int $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getHauteur(): ?int
    {
        return $this->hauteur;
    }

    public function setHauteur(int $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNomFichierImage(): ?string
    {
        return $this->nomFichierImage;
    }

    public function setNomFichierImage(string $nomFichierImage): self
    {
        $this->nomFichierImage = $nomFichierImage;

        return $this;
    }

    public function getIdType(): ?type
    {
        return $this->idType;
    }

    public function setIdType(?type $idType): self
    {
        $this->idType = $idType;

        return $this;
    }
}
