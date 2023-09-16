<?php

namespace App\Entity;

use App\Repository\AlphabetSoupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlphabetSoupRepository::class)]
class AlphabetSoup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private array $words = [];

    #[ORM\Column(nullable: true)]
    private ?array $traps = null;

    #[ORM\Column]
    private ?int $rows = null;

    #[ORM\Column]
    private ?int $columnSoup = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $currentDate = null;

    #[ORM\ManyToOne(inversedBy: 'alphabetSoups')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Video $video = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getWords(): array
    {
        return $this->words;
    }

    public function setWords(array $words): static
    {
        $this->words = $words;

        return $this;
    }

    public function getTraps(): ?array
    {
        return $this->traps;
    }

    public function setTraps(?array $traps): static
    {
        $this->traps = $traps;

        return $this;
    }

    public function getRows(): ?int
    {
        return $this->rows;
    }

    public function setRows(int $rows=11): static
    {
        $this->rows = $rows;

        return $this;
    }

    public function getColumnSoup(): ?int
    {
        return $this->columnSoup;
    }

    public function setColumnSoup(int $columnSoup=11): static
    {
        $this->columnSoup = $columnSoup;

        return $this;
    }

    public function getCurrentDate(): ?\DateTimeInterface
    {
        return $this->currentDate;
    }

    public function setCurrentDate(\DateTimeInterface $currentDate): static
    {
        $this->currentDate = $currentDate;

        return $this;
    }

    public function getVideo(): ?Video
    {
        return $this->video;
    }

    public function setVideo(?Video $video): static
    {
        $this->video = $video;

        return $this;
    }
}
