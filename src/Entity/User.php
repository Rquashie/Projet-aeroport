<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 180)]
    private ?string $nom= null;

    #[ORM\Column(length: 180)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180)]
    private ?string $ville = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne(targetEntity: Modele::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Modele $refModele = null;




    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];
    public function __construct()
    {
        //'ROLE_USER' par défaut
        $this->roles[] = 'ROLE_USER';
    }


    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
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
    public function getVille(): ?string
    {
        return $this->ville;
    }
    public function setVille(string $ville): static
    {
        $this->ville = $ville;
        return $this;
    }
    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }
    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function __toString(){
        return $this->nom.' '.$this->prenom;
    }
}
