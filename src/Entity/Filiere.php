<?php

namespace App\Entity;

use App\Repository\FiliereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FiliereRepository::class)
 * @ORM\Table(name="filiere")
 */
class Filiere
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="L'intitulé de la filière est obligatoire.")
     * @Assert\Length(min=3, max=150,
     *     minMessage="L'intitulé doit contenir au moins {{ limit }} caractères.",
     *     maxMessage="L'intitulé ne peut pas dépasser {{ limit }} caractères.")
     */
    private string $nom = '';

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Le niveau est obligatoire.")
     */
    private string $niveau = '';

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $description = null;

    /** @ORM\Column(type="string", length=100, nullable=true) */
    private ?string $duree = null;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $debouches = null;

    /**
     * @ORM\ManyToMany(targetEntity=Etablissement::class, inversedBy="filieres")
     * @ORM\JoinTable(name="filiere_etablissement")
     */
    private Collection $etablissements;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="filiere", cascade={"remove"})
     */
    private Collection $evenements;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->evenements     = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }
    public function getNiveau(): string { return $this->niveau; }
    public function setNiveau(string $niveau): self { $this->niveau = $niveau; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function getDuree(): ?string { return $this->duree; }
    public function setDuree(?string $duree): self { $this->duree = $duree; return $this; }
    public function getDebouches(): ?string { return $this->debouches; }
    public function setDebouches(?string $debouches): self { $this->debouches = $debouches; return $this; }
    /** @return Collection<int, Etablissement> */
    public function getEtablissements(): Collection { return $this->etablissements; }
    public function addEtablissement(Etablissement $etablissement): self {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements->add($etablissement);
        }
        return $this;
    }
    public function removeEtablissement(Etablissement $etablissement): self {
        $this->etablissements->removeElement($etablissement);
        return $this;
    }
    /** @return Collection<int, Evenement> */
    public function getEvenements(): Collection { return $this->evenements; }
    public function addEvenement(Evenement $evenement): self {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setFiliere($this);
        }
        return $this;
    }
    public function removeEvenement(Evenement $evenement): self {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getFiliere() === $this) {
                $evenement->setFiliere(null);
            }
        }
        return $this;
    }
    public function __toString(): string { return $this->nom; }
}
