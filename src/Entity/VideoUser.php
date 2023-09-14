<?php

namespace App\Entity;

use App\Repository\VideoUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoUserRepository::class)]
class VideoUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $currentTime = null;

    #[ORM\Column]
    private ?float $totalTime = null;

    #[ORM\ManyToOne(inversedBy: 'videoUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'videoUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Video $video = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrentTime(): ?float
    {
        return $this->currentTime;
    }

    public function setCurrentTime(float $currentTime): static
    {
        $this->currentTime = $currentTime;

        return $this;
    }

    public function getTotalTime(): ?float
    {
        return $this->totalTime;
    }

    public function setTotalTime(float $totalTime): static
    {
        $this->totalTime = $totalTime;

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
