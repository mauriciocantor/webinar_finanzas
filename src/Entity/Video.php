<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ReadableCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoRepository::class)]
class Video
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnail = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $link = null;

    #[ORM\Column]
    private array $availablesRoles = [];

    #[ORM\Column(type: Types::BINARY)]
    private $withTest = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $videoId = null;

    #[ORM\OneToMany(mappedBy: 'video', targetEntity: VideoUser::class)]
    private Collection $videoUsers;

    #[ORM\OneToMany(mappedBy: 'video', targetEntity: Question::class)]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'video', targetEntity: AlphabetSoup::class)]
    private Collection $alphabetSoups;

    #[ORM\ManyToOne(inversedBy: 'video')]
    private ?Hangman $hangman = null;

    #[ORM\OneToMany(mappedBy: 'video', targetEntity: HangmanResult::class)]
    private Collection $hangmanResults;

    #[ORM\Column(nullable: true)]
    private ?array $roleTest = null;

    #[ORM\Column(nullable: true)]
    private ?int $orderVideo = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    private ?ModuleVideo $module = null;


    public function __construct()
    {
        $this->videoUsers = new ArrayCollection();
        $this->questions = new ArrayCollection();
        $this->alphabetSoups = new ArrayCollection();
        $this->hangmanResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getAvailablesRoles(): array
    {
        return $this->availablesRoles;
    }

    public function setAvailablesRoles(array $availablesRoles): static
    {
        $this->availablesRoles = $availablesRoles;

        return $this;
    }

    public function getWithTest()
    {
        return $this->withTest;
    }

    public function setWithTest($withTest): static
    {
        $this->withTest = $withTest;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(string $videoId): static
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * @return Collection<int, VideoUser>
     */
    public function getVideoUsers(): Collection
    {
        return $this->videoUsers;
    }

    public function addVideoUser(VideoUser $videoUser): static
    {
        if (!$this->videoUsers->contains($videoUser)) {
            $this->videoUsers->add($videoUser);
            $videoUser->setVideo($this);
        }

        return $this;
    }

    public function removeVideoUser(VideoUser $videoUser): static
    {
        if ($this->videoUsers->removeElement($videoUser)) {
            // set the owning side to null (unless already changed)
            if ($videoUser->getVideo() === $this) {
                $videoUser->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setVideo($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getVideo() === $this) {
                $question->setVideo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AlphabetSoup>
     */
    public function getAlphabetSoups(): Collection
    {
        return $this->alphabetSoups;
    }

    public function addAlphabetSoup(AlphabetSoup $alphabetSoup): static
    {
        if (!$this->alphabetSoups->contains($alphabetSoup)) {
            $this->alphabetSoups->add($alphabetSoup);
            $alphabetSoup->setVideo($this);
        }

        return $this;
    }

    public function removeAlphabetSoup(AlphabetSoup $alphabetSoup): static
    {
        if ($this->alphabetSoups->removeElement($alphabetSoup)) {
            // set the owning side to null (unless already changed)
            if ($alphabetSoup->getVideo() === $this) {
                $alphabetSoup->setVideo(null);
            }
        }

        return $this;
    }

    public function getHangman(): ?Hangman
    {
        return $this->hangman;
    }

    public function setHangman(?Hangman $hangman): static
    {
        $this->hangman = $hangman;

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
            $hangmanResult->setVideo($this);
        }

        return $this;
    }

    public function removeHangmanResult(HangmanResult $hangmanResult): static
    {
        if ($this->hangmanResults->removeElement($hangmanResult)) {
            // set the owning side to null (unless already changed)
            if ($hangmanResult->getVideo() === $this) {
                $hangmanResult->setVideo(null);
            }
        }

        return $this;
    }

    public function getRoleTest(): ?array
    {
        return $this->roleTest;
    }

    public function setRoleTest(?array $roleTest): static
    {
        $this->roleTest = $roleTest;

        return $this;
    }

    public function getOrderVideo(): ?int
    {
        return $this->orderVideo;
    }

    public function setOrderVideo(?int $orderVideo): static
    {
        $this->orderVideo = $orderVideo;

        return $this;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getHangmanResultByUser(User $user): array
    {
        $hangmanResult =  $this->getHangmanResults()->filter(function (HangmanResult $hangmanResult) use ($user){
            return $hangmanResult->getUser() === $user;
        });

        $alphabetSoup = $this->alphabetSoups->filter(function (AlphabetSoup $alphabetSoup) use ($user){
            return count($alphabetSoup->getAlphabetSoupResults()->filter(function (AlphabetSoupResult $alphabetSoupResult) use ($user) {
                return $alphabetSoupResult->getUser() === $user;
            })) > 0;
        });

        return ['alphabetSoup'=>$alphabetSoup, 'hangmanResult' => $hangmanResult];
    }

    public function getModule(): ?ModuleVideo
    {
        return $this->module;
    }

    public function setModule(?ModuleVideo $module): static
    {
        $this->module = $module;

        return $this;
    }
}
