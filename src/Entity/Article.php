<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
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
}
