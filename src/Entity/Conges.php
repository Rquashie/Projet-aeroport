<?php

namespace App\Entity;

use App\Repository\CongesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongesRepository::class)]
class Conges
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    private ?bool $estValide = null;

    #[ORM\ManyToOne(inversedBy: 'conges')]
    private ?User $refPilote = null;

    #[ORM\ManyToOne(inversedBy: 'conges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $refValidationAdmin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function isEstValide(): ?bool
    {
        return $this->estValide;
    }

    public function setEstValide(bool $estValide): static
    {
        $this->estValide = $estValide;

        return $this;
    }

    public function getRefPilote(): ?User
    {
        return $this->refPilote;
    }

    public function setRefPilote(?User $refPilote): static
    {
        $this->refPilote = $refPilote;

        return $this;
    }

    public function getRefValidationAdmin(): ?User
    {
        return $this->refValidationAdmin;
    }

    public function setRefValidationAdmin(?User $refValidationAdmin): static
    {
        $this->refValidationAdmin = $refValidationAdmin;

        return $this;
    }
}
