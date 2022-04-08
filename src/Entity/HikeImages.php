<?php

namespace App\Entity;

use App\Repository\HikeImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HikeImagesRepository::class)]
class HikeImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('hike:read')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('hike:read')]
    private $name;

    #[ORM\ManyToOne(targetEntity: Hike::class, inversedBy: 'hikeImages')]
    private $hike;

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

    public function getHike(): ?Hike
    {
        return $this->hike;
    }

    public function setHike(?Hike $hike): self
    {
        $this->hike = $hike;

        return $this;
    }
}
