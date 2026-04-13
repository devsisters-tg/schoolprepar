<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $nom = '';

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $prenom = '';

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private string $email = '';

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private ?string $telephone = null;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $role = 'ROLE_ETUDIANT';

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $actif = true;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }

    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }

    public function getPrenom(): string { return $this->prenom; }
    public function setPrenom(string $prenom): self { $this->prenom = $prenom; return $this; }

    public function getNomComplet(): string { return $this->prenom . ' ' . $this->nom; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): self { $this->email = $email; return $this; }

    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $telephone): self { $this->telephone = $telephone; return $this; }

    public function getRole(): string { return $this->role; }
    public function setRole(string $role): self { $this->role = $role; return $this; }

    public function isActif(): bool { return $this->actif; }
    public function setActif(bool $actif): self { $this->actif = $actif; return $this; }

    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
    public function setCreatedAt(\DateTimeInterface $createdAt): self { $this->createdAt = $createdAt; return $this; }

    public function __toString(): string { return $this->getNomComplet(); }
}
