<?php

namespace App\Entity;

use App\Repository\DifficultyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DifficultyRepository::class)]
class Difficulty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('hike:read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('hike:read')]
    private $level;

    #[ORM\OneToMany(mappedBy: 'difficulty', targetEntity: Hike::class)]
    private $hikes;

    public function __construct()
    {
        $this->hikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Hike>
     */
    public function getHikes(): Collection
    {
        return $this->hikes;
    }

    public function addHike(Hike $hike): self
    {
        if (!$this->hikes->contains($hike)) {
            $this->hikes[] = $hike;
            $hike->setDifficulty($this);
        }

        return $this;
    }

    public function removeHike(Hike $hike): self
    {
        if ($this->hikes->removeElement($hike)) {
            // set the owning side to null (unless already changed)
            if ($hike->getDifficulty() === $this) {
                $hike->setDifficulty(null);
            }
        }

        return $this;
    }
}
