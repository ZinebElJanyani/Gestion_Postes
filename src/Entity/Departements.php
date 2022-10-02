<?php

namespace App\Entity;

use App\Repository\DepartementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartementsRepository::class)]
class Departements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_D = null;



    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: Plateaux::class)]
    private Collection $plateaux;

    #[ORM\OneToMany(mappedBy: 'departement', targetEntity: EmployeeUsers::class)]
    private Collection $employeeUsers;

    #[ORM\OneToOne(mappedBy: 'departement', cascade: ['persist', 'remove'])]
    private ?RCusers $RCuser = null;

    public function __construct()
    {
        $this->plateaux = new ArrayCollection();
        $this->employeeUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomD(): ?string
    {
        return $this->nom_D;
    }

    public function setNomD(string $nom_D): self
    {
        $this->nom_D = $nom_D;

        return $this;
    }


    /**
     * @return Collection<int, Plateaux>
     */
    public function getPlateaux(): Collection
    {
        return $this->plateaux;
    }

    public function addPlateau(Plateaux $plateau): self
    {
        if (!$this->plateaux->contains($plateau)) {
            $this->plateaux[] = $plateau;
            $plateau->setDepartement($this);
        }

        return $this;
    }

    public function removePlateau(Plateaux $plateau): self
    {
        if ($this->plateaux->removeElement($plateau)) {
            // set the owning side to null (unless already changed)
            if ($plateau->getDepartement() === $this) {
                $plateau->setDepartement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmployeeUsers>
     */
    public function getEmployeeUsers(): Collection
    {
        return $this->employeeUsers;
    }

    public function addEmployeeUser(EmployeeUsers $employeeUser): self
    {
        if (!$this->employeeUsers->contains($employeeUser)) {
            $this->employeeUsers[] = $employeeUser;
            $employeeUser->setDepartement($this);
        }

        return $this;
    }

    public function removeEmployeeUser(EmployeeUsers $employeeUser): self
    {
        if ($this->employeeUsers->removeElement($employeeUser)) {
            // set the owning side to null (unless already changed)
            if ($employeeUser->getDepartement() === $this) {
                $employeeUser->setDepartement(null);
            }
        }

        return $this;
    }

    public function getRCuser(): ?RCusers
    {
        return $this->RCuser;
    }

    public function setRCuser(?RCusers $RCuser): self
    {
        // unset the owning side of the relation if necessary
        if ($RCuser === null && $this->RCuser !== null) {
            $this->RCuser->setDepartement(null);
        }

        // set the owning side of the relation if necessary
        if ($RCuser !== null && $RCuser->getDepartement() !== $this) {
            $RCuser->setDepartement($this);
        }

        $this->RCuser = $RCuser;

        return $this;
    }
}
