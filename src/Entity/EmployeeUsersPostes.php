<?php

namespace App\Entity;

use App\Repository\EmployeeUsersPostesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeUsersPostesRepository::class)]
class EmployeeUsersPostes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'affectation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?EmployeeUsers $employe = null;

    #[ORM\OneToOne(inversedBy: 'affectation', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Postes $poste = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $date_affectation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmploye(): ?EmployeeUsers
    {
        return $this->employe;
    }

    public function setEmploye(EmployeeUsers $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getPoste(): ?Postes
    {
        return $this->poste;
    }

    public function setPoste(Postes $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getDateAffectation(): ?\DateTimeImmutable
    {
        return $this->date_affectation;
    }

    public function setDateAffectation(?\DateTimeImmutable $date_affectation): self
    {
        $this->date_affectation = $date_affectation;

        return $this;
    }
}
