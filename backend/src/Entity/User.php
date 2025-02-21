<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('user:read')]
    private ?int $id = null;
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 180)]
    #[Groups('user:read')]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\Length(
        min: 8, max: 100,
        minMessage: 'Your Password must be at least {{ limit }} characters long.', maxMessage: 'Your Password cannot  be longer than  {{ limit }} characters long.',
    )]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3, max: 50,
        minMessage: 'Your userName must be at least {{ limit }} characters long.', maxMessage: 'Your UserName cannot  be longer than  {{ limit }} characters long.',
    )]
    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $username = null;
    #[Assert\Length(
        min: 3, max: 50,
        minMessage: 'Your Name must be at least {{ limit }} characters long.', maxMessage: 'Your Name cannot  be longer than  {{ limit }} characters long.',
    )]
    #[ORM\Column(length: 255)]
    #[Groups('user:read')]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('user:read')]
    private ?string $last_name = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?int $age = null;

    #[ORM\Column(nullable: true)]
    #[Groups('user:read')]
    private ?string $profileImage = null;

    #[Vich\UploadableField(mapping: 'user_images', fileNameProperty: 'profileImage')]
    private ?File $profileImageFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    /**
     * @var Collection<int, Priority>
     */
    #[ORM\OneToMany(targetEntity: Priority::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    /* if user deleted any priorities here is deleted */
    private Collection $customPriorities;

    /**
     * @var Collection<int, Status>
     */
    #[ORM\OneToMany(targetEntity: Status::class, mappedBy: 'user', cascade: ['persist', 'remove'])]
    private Collection $customStatuses;

    public function __construct()
    {
        $this->customPriorities = new ArrayCollection();
        $this->customStatuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function setProfileImageFile(?File $profileImageFile = null): void
    {
        $this->profileImageFile = $profileImageFile;
        if ($profileImageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getProfileImageFile(): ?File
    {
        return $this->profileImageFile;
    }

    public function setProfileImage(?string $profileImage): void
    {
        $this->profileImage = $profileImage;
    }

    public function getProfileImage(): ?string
    {
        return $this->profileImage;
    }

    /**
     * @return Collection<int, Priority>
     */
    public function getCustomPriorities(): Collection
    {
        return $this->customPriorities;
    }

    public function addCustomPriority(Priority $customPriority): static
    {
        if (!$this->customPriorities->contains($customPriority)) {
            $this->customPriorities->add($customPriority);
            $customPriority->setUserId($this);
        }

        return $this;
    }

    public function removeCustomPriority(Priority $customPriority): static
    {
        if ($this->customPriorities->removeElement($customPriority)) {
            // set the owning side to null (unless already changed)
            if ($customPriority->getUser() === $this) {
                $customPriority->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Status>
     */
    public function getCustomStatuses(): Collection
    {
        return $this->customStatuses;
    }

    public function addCustomStatus(Status $customStatus): static
    {
        if (!$this->customStatuses->contains($customStatus)) {
            $this->customStatuses->add($customStatus);
            $customStatus->setGg($this);
        }

        return $this;
    }

    public function removeCustomStatus(Status $customStatus): static
    {
        if ($this->customStatuses->removeElement($customStatus)) {
            // set the owning side to null (unless already changed)
            if ($customStatus->getGg() === $this) {
                $customStatus->setGg(null);
            }
        }

        return $this;
    }
}
