<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="user")
 * @UniqueEntity(fields={"email"}, message="Cette adresse e-mail est déjà utilisée.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le nom est obligatoire.")
     * @Assert\Length(min=2, max=100)
     */
    private $nom = '';

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Le prénom est obligatoire.")
     * @Assert\Length(min=2, max=100)
     */
    private $prenom = '';

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message="L'e-mail est obligatoire.")
     * @Assert\Email(message="Adresse e-mail invalide.")
     */
    private $email = '';

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string")
     */
    private $password = '';

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif = true;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId() { return $this->id; }

    public function getNom() { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrenom() { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getNomComplet(): string { return $this->prenom . ' ' . $this->nom; }

    public function getEmail() { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getTelephone() { return $this->telephone; }
    public function setTelephone(?string $telephone): self { $this->telephone = $telephone; return $this; }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self { $this->roles = $roles; return $this; }

    public function getPassword() { return $this->password; }
    public function setPassword(string $password): self { $this->password = $password; return $this; }

    public function isActif() { return $this->actif; }
    public function setActif(bool $actif): self { $this->actif = $actif; return $this; }

    public function getCreatedAt() { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): self { $this->createdAt = $createdAt; return $this; }

    // Méthodes requises par UserInterface en Symfony 5 / PHP 7.4
    public function getUsername(): string { return $this->email; }
    public function getUserIdentifier(): string { return $this->email; }
    public function getSalt(): ?string { return null; }
    public function eraseCredentials(): void {}

    public function __toString(): string { return $this->getNomComplet(); }
}