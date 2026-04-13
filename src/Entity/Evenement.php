<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 * @ORM\Table(name="evenement")
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /** @ORM\Column(type="string", length=200) */
    private string $titre = '';

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $description = null;

    /** @ORM\Column(type="datetime") */
    private \DateTimeInterface $dateEvenement;

    /** @ORM\Column(type="string", length=150, nullable=true) */
    private ?string $lieu = null;

    /** @ORM\Column(type="string", length=50, nullable=true) */
    private ?string $type = null;

    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="evenements")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Filiere $filiere = null;

    /**
     * @ORM\ManyToOne(targetEntity=Etablissement::class, inversedBy="evenements")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Etablissement $etablissement = null;

    public function __construct()
    {
        $this->dateEvenement = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }

    public function getTitre(): string { return $this->titre; }
    public function setTitre(string $titre): self { $this->titre = $titre; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }

    public function getDateEvenement(): \DateTimeInterface { return $this->dateEvenement; }
    public function setDateEvenement(\DateTimeInterface $date): self { $this->dateEvenement = $date; return $this; }

    public function getLieu(): ?string { return $this->lieu; }
    public function setLieu(?string $lieu): self { $this->lieu = $lieu; return $this; }

    public function getType(): ?string { return $this->type; }
    public function setType(?string $type): self { $this->type = $type; return $this; }

    public function getFiliere(): ?Filiere { return $this->filiere; }
    public function setFiliere(?Filiere $filiere): self { $this->filiere = $filiere; return $this; }

    public function getEtablissement(): ?Etablissement { return $this->etablissement; }
    public function setEtablissement(?Etablissement $etablissement): self { $this->etablissement = $etablissement; return $this; }

    public function __toString(): string { return $this->titre; }
}