<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
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
     * @ORM\Column(type="string", length=255)
     */
    private $nomFichierImage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateHeureEnregistrement;

    /**
     * @ORM\Column(type="text")
     */
    private $corpsArticle;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="listeArticles", cascade={"persist"})
     */
    private $listeTags;

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

    public function getNomFichierImage(): ?string
    {
        return $this->nomFichierImage;
    }

    public function setNomFichierImage(string $nomFichierImage): self
    {
        $this->nomFichierImage = $nomFichierImage;

        return $this;
    }

    public function getDateHeureEnregistrement(): ?\DateTimeInterface
    {
        return $this->dateHeureEnregistrement;
    }

    public function setDateHeureEnregistrement(\DateTimeInterface $dateHeureEnregistrement): self
    {
        $this->dateHeureEnregistrement = $dateHeureEnregistrement;

        return $this;
    }

    public function getCorpsArticle(): ?string
    {
        return $this->corpsArticle;
    }

    public function setCorpsArticle(string $corpsArticle): self
    {
        $this->corpsArticle = $corpsArticle;

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
    
    public function setArticle(string $titre, \DateTimeInterface $dateHeureEnregistrement, string $nomFichierImage, string $corpsArticle){
        $this->titre = $titre;
        $this->dateHeureEnregistrement = $dateHeureEnregistrement;
        $this->nomFichierImage = $nomFichierImage;
        $this->corpsArticle = $corpsArticle;
    }
}
