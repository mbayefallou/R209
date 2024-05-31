<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Niveau::class, mappedBy: 'category')]
    private Collection $niveaux;

    #[ORM\OneToMany(targetEntity: Veille::class, mappedBy: 'category')]
    private Collection $veilles;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
        $this->veilles = new ArrayCollection();
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

    /**
     * @return Collection<int, Niveau>
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): static
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux->add($niveau);
            $niveau->setCategory($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): static
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCategory() === $this) {
                $niveau->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Veille>
     */
    public function getVeilles(): Collection
    {
        return $this->veilles;
    }

    public function addVeille(Veille $veille): static
    {
        if (!$this->veilles->contains($veille)) {
            $this->veilles->add($veille);
            $veille->setCategory($this);
        }

        return $this;
    }

    public function removeVeille(Veille $veille): static
    {
        if ($this->veilles->removeElement($veille)) {
            // set the owning side to null (unless already changed)
            if ($veille->getCategory() === $this) {
                $veille->setCategory(null);
            }
        }

        return $this;
    }
}
