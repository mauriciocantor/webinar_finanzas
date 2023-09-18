<?php

namespace App\Entity;

use App\Repository\AlphabetSoupResultRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlphabetSoupResultRepository::class)]
class AlphabetSoupResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $live = null;

    #[ORM\Column]
    private array $foundWord = [];

    #[ORM\Column]
    private ?bool $isCorrect = null;

    #[ORM\ManyToOne(inversedBy: 'alphabetSoupResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AlphabetSoup $alphabetSoup = null;

    #[ORM\ManyToOne(inversedBy: 'alphabetSoupResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateResult = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLive(): ?int
    {
        return $this->live;
    }

    public function setLive(int $live): static
    {
        $this->live = $live;

        return $this;
    }

    public function getFoundWord(): array
    {
        return $this->foundWord;
    }

    public function setFoundWord(array $foundWord): static
    {
        $this->foundWord = $foundWord;

        return $this;
    }

    public function isIsCorrect(): ?bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;

        return $this;
    }

    public function getAlphabetSoup(): ?AlphabetSoup
    {
        return $this->alphabetSoup;
    }

    public function setAlphabetSoup(?AlphabetSoup $alphabetSoup): static
    {
        $this->alphabetSoup = $alphabetSoup;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDateResult(): ?\DateTimeInterface
    {
        return $this->dateResult;
    }

    public function setDateResult(?\DateTimeInterface $dateResult): static
    {
        $this->dateResult = $dateResult;

        return $this;
    }
}
