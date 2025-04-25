<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?User $refUtilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    private ?Vol $refVol = null;

    #[ORM\Column]
    private ?float $prixBillet = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefUtilisateur(): ?User
    {
        return $this->refUtilisateur;
    }

    public function setRefUtilisateur(?User $refUtilisateur): static
    {
        $this->refUtilisateur = $refUtilisateur;

        return $this;
    }

    public function getRefVol(): ?Vol
    {
        return $this->refVol;
    }

    public function setRefVol(?Vol $refVol): static
    {
        $this->refVol = $refVol;

        return $this;
    }

    public function getPrixBillet(): ?float
    {
        return $this->prixBillet;
    }

    public function setPrixBillet(float $prixBillet): static
    {
        $this->prixBillet = $prixBillet;

        return $this;
    }
}
