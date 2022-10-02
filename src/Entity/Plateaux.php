<?php

namespace App\Entity;

use App\Repository\PlateauxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlateauxRepository::class)]
class Plateaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'plateaux')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departements $departement = null;

    #[ORM\OneToMany(mappedBy: 'plateau', targetEntity: Postes::class)]
    private Collection $postes;

    private ?string $depart =null;

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function __construct()
    {
        $this->postes = new ArrayCollection();
    }

    public function getid(): ?int
    {
        return $this->id;
    }

    public function getDepartement(): ?Departements
    {
        return $this->departement;
    }

    public function setDepartement(?Departements $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection<int, Postes>
     */
    public function getPostes(): Collection
    {
        return $this->postes;
    }

    public function addPoste(Postes $poste): self
    {
        if (!$this->postes->contains($poste)) {
            $this->postes[] = $poste;
            $poste->setPlateau($this);
        }

        return $this;
    }

    public function removePoste(Postes $poste): self
    {
        if ($this->postes->removeElement($poste)) {
            // set the owning side to null (unless already changed)
            if ($poste->getPlateau() === $this) {
                $poste->setPlateau(null);
            }
        }

        return $this;
    }
}
