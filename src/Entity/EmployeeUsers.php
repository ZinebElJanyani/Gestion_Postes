<?php

namespace App\Entity;

use App\Repository\EmployeeUsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EmployeeUsersRepository::class)]
class EmployeeUsers implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true, options: ["default" => 0])]
    private ?string $email = '';

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(options: ["default" => 'password'])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    private ?string $depart =null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre_poste = null;

    #[ORM\ManyToOne(inversedBy: 'employeeUsers')]
    private ?Departements $departement = null;

    // #[ORM\ManyToMany(targetEntity: Postes::class, inversedBy: 'employeeUsers')]
    // private Collection $poste;

    #[ORM\OneToOne(mappedBy: 'employe', cascade: ['persist', 'remove'])]
    private ?EmployeeUsersPostes $affectation = null;

    #[ORM\OneToOne(mappedBy: 'employe', cascade: ['persist', 'remove'])]
    private ?Affectation $Naffectation = null;

    public function __construct()
    {
        $this->poste = new ArrayCollection();
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    

    public function getTitrePoste(): ?string
    {
        return $this->titre_poste;
    }

    public function setTitrePoste(?string $titre_poste): self
    {
        $this->titre_poste = $titre_poste;
 
        return $this;
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

    // /**
    //  * @return Collection<int, Postes>
    //  */
    // public function getPoste(): Collection
    // {
    //     return $this->poste;
    // }

    // public function addPoste(Postes $poste): self
    // {
    //     if (!$this->poste->contains($poste)) {
    //         $this->poste[] = $poste;
    //     }

    //     return $this;
    // }

    // public function removePoste(Postes $poste): self
    // {
    //     $this->poste->removeElement($poste);

    //     return $this;
    // }

    public function getAffectation(): ?EmployeeUsersPostes
    {
        return $this->affectation;
    }

    public function setAffectation(EmployeeUsersPostes $affectation): self
    {
        // set the owning side of the relation if necessary
        if ($affectation->getEmploye() !== $this) {
            $affectation->setEmploye($this);
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
        if ($Naffectation->getEmploye() !== $this) {
            $Naffectation->setEmploye($this);
        }

        $this->Naffectation = $Naffectation;

        return $this;
    }
}
