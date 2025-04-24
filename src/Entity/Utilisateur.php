<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\Column(type:'date')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Modele $refModele = null;

    /**
     * @var Collection<int, Vol>
     */
    #[ORM\OneToMany(targetEntity: Vol::class, mappedBy: 'refPilote')]
    private Collection $vols;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'refUtilisateur')]
    private Collection $reservations;

    /**
     * @var Collection<int, Conges>
     */
    #[ORM\OneToMany(targetEntity: Conges::class, mappedBy: 'refPilote')]
    private Collection $conges;

    public function __construct()
    {
        $this->vols = new ArrayCollection();
        $this->reservations = new ArrayCollection();
        $this->conges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTime $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getRefModele(): ?Modele
    {
        return $this->refModele;
    }

    public function setRefModele(?Modele $refModele): static
    {
        $this->refModele = $refModele;

        return $this;
    }

    /**
     * @return Collection<int, Vol>
     */
    public function getVols(): Collection
    {
        return $this->vols;
    }

    public function addVol(Vol $vol): static
    {
        if (!$this->vols->contains($vol)) {
            $this->vols->add($vol);
            $vol->setRefPilote($this);
        }

        return $this;
    }

    public function removeVol(Vol $vol): static
    {
        if ($this->vols->removeElement($vol)) {
            // set the owning side to null (unless already changed)
            if ($vol->getRefPilote() === $this) {
                $vol->setRefPilote(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setRefUtilisateur($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getRefUtilisateur() === $this) {
                $reservation->setRefUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conges>
     */
    public function getConges(): Collection
    {
        return $this->conges;
    }

    public function addConge(Conges $conge): static
    {
        if (!$this->conges->contains($conge)) {
            $this->conges->add($conge);
            $conge->setRefPilote($this);
        }

        return $this;
    }

    public function removeConge(Conges $conge): static
    {
        if ($this->conges->removeElement($conge)) {
            // set the owning side to null (unless already changed)
            if ($conge->getRefPilote() === $this) {
                $conge->setRefPilote(null);
            }
        }

        return $this;
    }
}
