<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: VideoUser::class)]
    private Collection $videoUsers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserAnswer::class)]
    private Collection $userAnswers;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: HangmanResult::class)]
    private Collection $hangmanResults;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: AlphabetSoupResult::class)]
    private Collection $alphabetSoupResults;

    public function __construct()
    {
        $this->videoUsers = new ArrayCollection();
        $this->userAnswers = new ArrayCollection();
        $this->hangmanResults = new ArrayCollection();
        $this->alphabetSoupResults = new ArrayCollection();
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
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function getRoleUnique(): string
    {
        $roles = $this->roles;
        $group = '';
        switch ($roles[0]){
            case 'ROLE_ADMIN':
                $group='Administración';
                break;
            case 'ROLE_PLATINUM':
                $group='Grupo 3';
                break;
            case 'ROLE_SILVER':
                $group='Grupo 1';
                break;
            case 'ROLE_GOLDEN':
                $group='Grupo 2';
                break;
        }

        return $group;
    }


    public function setRoles(array $roles): static
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

    /**
     * @return Collection<int, VideoUser>
     */
    public function getVideo(): Collection
    {
        return $this->videoUsers;
    }

    public function addVideo(VideoUser $video): static
    {
        if (!$this->videoUsers->contains($video)) {
            $this->videoUsers->add($video);
            $video->setUser($this);
        }

        return $this;
    }

    public function removeVideo(VideoUser $video): static
    {
        if ($this->videoUsers->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getUser() === $this) {
                $video->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserAnswer>
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(UserAnswer $userAnswer): static
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->add($userAnswer);
            $userAnswer->setUser($this);
        }

        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): static
    {
        if ($this->userAnswers->removeElement($userAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userAnswer->getUser() === $this) {
                $userAnswer->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, HangmanResult>
     */
    public function getHangmanResults(): Collection
    {
        return $this->hangmanResults;
    }

    public function addHangmanResult(HangmanResult $hangmanResult): static
    {
        if (!$this->hangmanResults->contains($hangmanResult)) {
            $this->hangmanResults->add($hangmanResult);
            $hangmanResult->setUser($this);
        }

        return $this;
    }

    public function removeHangmanResult(HangmanResult $hangmanResult): static
    {
        if ($this->hangmanResults->removeElement($hangmanResult)) {
            // set the owning side to null (unless already changed)
            if ($hangmanResult->getUser() === $this) {
                $hangmanResult->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AlphabetSoupResult>
     */
    public function getAlphabetSoupResults(): Collection
    {
        return $this->alphabetSoupResults;
    }

    public function addAlphabetSoupResult(AlphabetSoupResult $alphabetSoupResult): static
    {
        if (!$this->alphabetSoupResults->contains($alphabetSoupResult)) {
            $this->alphabetSoupResults->add($alphabetSoupResult);
            $alphabetSoupResult->setUser($this);
        }

        return $this;
    }

    public function removeAlphabetSoupResult(AlphabetSoupResult $alphabetSoupResult): static
    {
        if ($this->alphabetSoupResults->removeElement($alphabetSoupResult)) {
            // set the owning side to null (unless already changed)
            if ($alphabetSoupResult->getUser() === $this) {
                $alphabetSoupResult->setUser(null);
            }
        }

        return $this;
    }
}
