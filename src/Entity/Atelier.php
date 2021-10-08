<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AtelierRepository::class)
 */
class Atelier
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
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbPlace;

    /**
     * @ORM\OneToMany(targetEntity=Inscription::class, mappedBy="idAtelier", orphanRemoval=true)
     */
    private $listeInscriptions;

    public function __construct()
    {
        $this->listeInscriptions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNbPlace(): ?int
    {
        return $this->nbPlace;
    }

    public function setNbPlace(int $nbPlace): self
    {
        $this->nbPlace = $nbPlace;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getListeInscriptions(): Collection
    {
        return $this->listeInscriptions;
    }

    public function addListeInscription(Inscription $listeInscription): self
    {
        if (!$this->listeInscriptions->contains($listeInscription)) {
            $this->listeInscriptions[] = $listeInscription;
            $listeInscription->setIdAtelier($this);
        }

        return $this;
    }

    public function removeListeInscription(Inscription $listeInscription): self
    {
        if ($this->listeInscriptions->removeElement($listeInscription)) {
            // set the owning side to null (unless already changed)
            if ($listeInscription->getIdAtelier() === $this) {
                $listeInscription->setIdAtelier(null);
            }
        }

        return $this;
    }
}
