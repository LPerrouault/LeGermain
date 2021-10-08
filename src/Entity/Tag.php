<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
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
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=Oeuvre::class, mappedBy="listeTags")
     */
    private $listeOeuvres;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="listeTags")
     */
    private $listeArticles;

    public function __construct()
    {
        $this->listeOeuvres = new ArrayCollection();
        $this->listeArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Oeuvre[]
     */
    public function getListeOeuvres(): Collection
    {
        return $this->listeOeuvres;
    }

    public function addListeOeuvre(Oeuvre $listeOeuvre): self
    {
        if (!$this->listeOeuvres->contains($listeOeuvre)) {
            $this->listeOeuvres[] = $listeOeuvre;
            $listeOeuvre->addListeTag($this);
        }

        return $this;
    }

    public function removeListeOeuvre(Oeuvre $listeOeuvre): self
    {
        if ($this->listeOeuvres->removeElement($listeOeuvre)) {
            $listeOeuvre->removeListeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getListeArticles(): Collection
    {
        return $this->listeArticles;
    }

    public function addListeArticle(Article $listeArticle): self
    {
        if (!$this->listeArticles->contains($listeArticle)) {
            $this->listeArticles[] = $listeArticle;
            $listeArticle->addListeTag($this);
        }

        return $this;
    }

    public function removeListeArticle(Article $listeArticle): self
    {
        if ($this->listeArticles->removeElement($listeArticle)) {
            $listeArticle->removeListeTag($this);
        }

        return $this;
    }
}
