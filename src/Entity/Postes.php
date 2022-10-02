<?php

namespace App\Entity;

use App\Repository\PostesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostesRepository::class)]
class Postes
{    

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'postes')]
    private ?Plateaux $plateau = null;

    // #[ORM\ManyToMany(targetEntity: EmployeeUsers::class, mappedBy: 'poste')]
    // private Collection $employeeUsers;

    #[ORM\Column]
    private ?int $N_poste = null;

    #[ORM\OneToOne(mappedBy: 'poste', cascade: ['persist', 'remove'])]
    private ?EmployeeUsersPostes $affectation = null;

    #[ORM\OneToOne(mappedBy: 'poste', cascade: ['persist', 'remove'])]
    private ?Affectation $Naffectation = null;

    public function __construct()
    {
        $this->employeeUsers = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlateau(): ?Plateaux
    {
        return $this->plateau;
    }

    public function setPlateau(?Plateaux $plateau): self
    {
        $this->plateau = $plateau;

        return $this;
    }

    // /**
    //  * @return Collection<int, EmployeeUsers>
    //  */
    // public function getEmployeeUsers(): Collection
    // {
    //     return $this->employeeUsers;
    // }

    // public function addEmployeeUser(EmployeeUsers $employeeUser): self
    // {
    //     if (!$this->employeeUsers->contains($employeeUser)) {
    //         $this->employeeUsers[] = $employeeUser;
    //         $employeeUser->addPoste($this);
    //     }

    //     return $this;
    // }

    // public function removeEmployeeUser(EmployeeUsers $employeeUser): self
    // {
    //     if ($this->employeeUsers->removeElement($employeeUser)) {
    //         $employeeUser->removePoste($this);
    //     }

    //     return $this;
    // }

    public function getNPoste(): ?int
    {
        return $this->N_poste;
    }

    public function setNPoste(int $N_poste): self
    {
        $this->N_poste = $N_poste;

        return $this;
    }

    public function getAffectation(): ?EmployeeUsersPostes
    {
        return $this->affectation;
    }

    public function setAffectation(EmployeeUsersPostes $affectation): self
    {
        // set the owning side of the relation if necessary
        if ($affectation->getPoste() !== $this) {
            $affectation->setPoste($this);
        }

        $this->affectation = $affectation;

        return $this;
    }

    public function getNaffectation(): ?Affectation
    {
        return $this->Naffectation;
    }

    public function setNaffectation(Affectation $Naffectation): self
    {
        // set the owning side of the relation if necessary
        if ($Naffectation->getPoste() !== $this) {
            $Naffectation->setPoste($this);
        }

        $this->Naffectation = $Naffectation;

        return $this;
    }

}
