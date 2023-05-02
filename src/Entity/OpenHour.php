<?php

namespace App\Entity;

use App\Repository\OpenHourRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpenHourRepository::class)]
class OpenHour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $mourningStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $mourningStopTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eveningStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $eveningStopTime = null;

    #[ORM\ManyToOne(inversedBy: 'openHours')]
    private ?Restaurant $relation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getMourningStartTime(): ?\DateTimeInterface
    {
        return $this->mourningStartTime;
    }

    public function setMourningStartTime(?\DateTimeInterface $mourningStartTime): self
    {
        $this->mourningStartTime = $mourningStartTime;

        return $this;
    }

    public function getMourningStopTime(): ?\DateTimeInterface
    {
        return $this->mourningStopTime;
    }

    public function setMourningStopTime(?\DateTimeInterface $mourningStopTime): self
    {
        $this->mourningStopTime = $mourningStopTime;

        return $this;
    }

    public function getEveningStartTime(): ?\DateTimeInterface
    {
        return $this->eveningStartTime;
    }

    public function setEveningStartTime(?\DateTimeInterface $eveningStartTime): self
    {
        $this->eveningStartTime = $eveningStartTime;

        return $this;
    }

    public function getEveningStopTime(): ?\DateTimeInterface
    {
        return $this->eveningStopTime;
    }

    public function setEveningStopTime(?\DateTimeInterface $eveningStopTime): self
    {
        $this->eveningStopTime = $eveningStopTime;

        return $this;
    }

    public function getRelation(): ?Restaurant
    {
        return $this->relation;
    }

    public function setRelation(?Restaurant $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
