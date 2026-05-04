<?php

namespace App\Entity;

use App\Repository\EtablissementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EtablissementRepository::class)
 * @ORM\Table(name="etablissement")
 */
class Etablissement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank(message="Le nom de l'établissement est obligatoire.")
     * @Assert\Length(min=3, max=200,
     *     minMessage="Le nom doit contenir au moins {{ limit }} caractères.",
     *     maxMessage="Le nom ne peut pas dépasser {{ limit }} caractères.")
     */
    private string $nom = '';

    /** @ORM\Column(type="string", length=30, nullable=true) */
    private ?string $sigle = null;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="La ville est obligatoire.")
     */
    private string $ville = '';

    /** @ORM\Column(type="string", length=100, nullable=true) */
    private ?string $type = null;

    /** @ORM\Column(type="text", nullable=true) */
    private ?string $description = null;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     * @Assert\Email(message="L'adresse e-mail de contact est invalide.")
     */
    private ?string $email = null;

    /** @ORM\Column(type="string", length=30, nullable=true) */
    private ?string $telephone = null;

    /**
     * @ORM\ManyToMany(targetEntity=Filiere::class, mappedBy="etablissements")
     */
    private Collection $filieres;

    /**
     * @ORM\OneToMany(targetEntity=Evenement::class, mappedBy="etablissement", cascade={"remove"})
     */
    private Collection $evenements;

    public function __construct()
    {
        $this->filieres   = new ArrayCollection();
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getNom(): string { return $this->nom; }
    public function setNom(string $nom): self { $this->nom = $nom; return $this; }
    public function getSigle(): ?string { return $this->sigle; }
    public function setSigle(?string $sigle): self { $this->sigle = $sigle; return $this; }
    public function getVille(): string { return $this->ville; }
    public function setVille(string $ville): self { $this->ville = $ville; return $this; }
    public function getType(): ?string { return $this->type; }
    public function setType(?string $type): self { $this->type = $type; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): self { $this->email = $email; return $this; }
    public function getTelephone(): ?string { return $this->telephone; }
    public function setTelephone(?string $telephone): self { $this->telephone = $telephone; return $this; }
    /** @return Collection<int, Filiere> */
    public function getFilieres(): Collection { return $this->filieres; }
    /** @return Collection<int, Evenement> */
    public function getEvenements(): Collection { return $this->evenements; }
    public function addEvenement(Evenement $evenement): self {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setEtablissement($this);
        }
        return $this;
    }
    public function removeEvenement(Evenement $evenement): self {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getEtablissement() === $this) {
                $evenement->setEtablissement(null);
            }
        }
        return $this;
    }
    public function __toString(): string { return $this->nom; }
}
