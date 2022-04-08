<?php

namespace App\Entity;

use App\Repository\HikeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HikeRepository::class)]
class Hike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('hike:read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('hike:read')]
    private $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups('hike:read')]
    private $Content;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('hike:read')]
    private $length;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('hike:read')]
    private $duration;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('hike:read')]
    private $elevation_gain;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups('hike:read')]
    private $elevation_loss;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('hike:read')]
    private $gps_coordonate;

    #[ORM\ManyToOne(targetEntity: Difficulty::class, inversedBy: 'hikes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('hike:read')]
    private $difficulty;

    #[ORM\OneToMany(mappedBy: 'hike', targetEntity: HikeImages::class)]
    #[Groups('hike:read')]
    private $hikeImages;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups('hike:read')]
    private $nameSlugger;

    public function __construct()
    {
        $this->hikeImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getLength(): ?float
    {
        return $this->length;
    }

    public function setLength(?float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getDuration(): ?float
    {
        return $this->duration;
    }

    public function setDuration(?float $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getElevationGain(): ?float
    {
        return $this->elevation_gain;
    }

    public function setElevationGain(?float $elevation_gain): self
    {
        $this->elevation_gain = $elevation_gain;

        return $this;
    }

    public function getElevationLoss(): ?float
    {
        return $this->elevation_loss;
    }

    public function setElevationLoss(?float $elevation_loss): self
    {
        $this->elevation_loss = $elevation_loss;

        return $this;
    }

    public function getGpsCoordonate(): ?string
    {
        return $this->gps_coordonate;
    }

    public function setGpsCoordonate(?string $gps_coordonate): self
    {
        $this->gps_coordonate = $gps_coordonate;

        return $this;
    }

    public function getDifficulty(): ?Difficulty
    {
        return $this->difficulty;
    }

    public function setDifficulty(?Difficulty $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection<int, HikeImages>
     */
    public function getHikeImages(): Collection
    {
        return $this->hikeImages;
    }

    public function addHikeImage(HikeImages $hikeImage): self
    {
        if (!$this->hikeImages->contains($hikeImage)) {
            $this->hikeImages[] = $hikeImage;
            $hikeImage->setHike($this);
        }

        return $this;
    }

    public function removeHikeImage(HikeImages $hikeImage): self
    {
        if ($this->hikeImages->removeElement($hikeImage)) {
            // set the owning side to null (unless already changed)
            if ($hikeImage->getHike() === $this) {
                $hikeImage->setHike(null);
            }
        }

        return $this;
    }

    public function getNameSlugger(): ?string
    {
        return $this->nameSlugger;
    }

    public function setNameSlugger(?string $nameSlugger): self
    {
        $this->nameSlugger = $nameSlugger;

        return $this;
    }
}
