<?php

namespace App\Entity;

use App\Repository\OeuvreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToOne(targetEntity=Type::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idType;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="listeOeuvres", cascade={"persist"})
     */
    private $listeTags;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publication;

    public function __construct()
    {
        $this->listeTags = new ArrayCollection();
    }

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

    public function getIdType(): ?Type
    {
        return $this->idType;
    }

    public function setIdType(?Type $idType): self
    {
        $this->idType = $idType;

        return $this;
    }
    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->date_publication;
    }

    public function setDatePublication(\DateTimeInterface $date_publication): self
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getListeTags(): Collection
    {
        return $this->listeTags;
    }

    public function addListeTag(Tag $listeTag): self
    {
        if (!$this->listeTags->contains($listeTag)) {
            $this->listeTags[] = $listeTag;
        }

        return $this;
    }

    public function removeListeTag(Tag $listeTag): self
    {
        $this->listeTags->removeElement($listeTag);

        return $this;
    }
    
    public function setOeuvre(string $titre, int $largeur, int $hauteur, string $nomFichierImage, string $description, ?Type $idType,\DateTime $datePublication){
        $this->titre = $titre;
        $this->largeur = $largeur;
        $this->hauteur = $hauteur;
        $this->nomFichierImage = $nomFichierImage;
        $this->description = $description;
        $this->idType = $idType;
        $this->date_publication = $datePublication;
    }
}