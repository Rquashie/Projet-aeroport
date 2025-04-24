<?php

namespace App\Entity;

use App\Repository\ModeleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModeleRepository::class)]
class Modele
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $modele = null;

    #[ORM\Column(length: 255)]
    private ?string $marque = null;

    /**
     * @var Collection<int, Avion>
     */
    #[ORM\OneToMany(targetEntity: Avion::class, mappedBy: 'refModele')]
    private Collection $avions;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'refModele')]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->avions = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): static
    {
        $this->modele = $modele;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * @return Collection<int, Avion>
     */
    public function getAvions(): Collection
    {
        return $this->avions;
    }

    public function addAvion(Avion $avion): static
    {
        if (!$this->avions->contains($avion)) {
            $this->avions->add($avion);
            $avion->setRefModele($this);
        }

        return $this;
    }

    public function removeAvion(Avion $avion): static
    {
        if ($this->avions->removeElement($avion)) {
            // set the owning side to null (unless already changed)
            if ($avion->getRefModele() === $this) {
                $avion->setRefModele(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setRefModele($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getRefModele() === $this) {
                $utilisateur->setRefModele(null);
            }
        }

        return $this;
    }
}
