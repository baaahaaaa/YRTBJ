<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The title should not be empty.")]
    #[Assert\Length(max: 255, maxMessage: "The title should not exceed 255 characters.")]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The description should not be empty.")]
    #[Assert\Length(max: 255, maxMessage: "The description should not exceed 255 characters.")]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The domain should not be empty.")]
    #[Assert\Length(max: 255, maxMessage: "The domain should not exceed 255 characters.")]
    private ?string $Domain = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "The type should not be empty.")]
    #[Assert\Length(max: 255, maxMessage: "The type should not exceed 255 characters.")]
    private ?string $Type = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Type(type: "float", message: "The price must be a valid number.")]
    #[Assert\GreaterThanOrEqual(value: 0, message: "The price must be a positive value.")]
    private ?float $Price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $CreationDate = null;

    /**
     * @var Collection<int, Ressource>
     */
    #[ORM\OneToMany(targetEntity: Ressource::class, mappedBy: 'courses', cascade: ['remove'])]
    private Collection $ressources;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    private ?Tutor $tutor = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'courses')]
    private Collection $student;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Course')]
    private Collection $users;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
        $this->student = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->Domain;
    }

    public function setDomain(string $Domain): static
    {
        $this->Domain = $Domain;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(?float $Price): static
    {
        $this->Price = $Price;

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->CreationDate;
    }

    public function setCreationDate(\DateTimeInterface $CreationDate): static
    {
        $this->CreationDate = $CreationDate;

        return $this;
    }

    /**
     * @return Collection<int, Ressource>
     */
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources->add($ressource);
            $ressource->setCourses($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->ressources->removeElement($ressource)) {
            // set the owning side to null (unless already changed)
            if ($ressource->getCourses() === $this) {
                $ressource->setCourses(null);
            }
        }

        return $this;
    }

    public function getTutor(): ?Tutor
    {
        return $this->tutor;
    }

    public function setTutor(?Tutor $tutor): static
    {
        $this->tutor = $tutor;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->student->contains($student)) {
            $this->student->add($student);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        $this->student->removeElement($student);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCourse($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeCourse($this);
        }

        return $this;
    }
}