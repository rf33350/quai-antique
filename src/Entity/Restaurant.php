<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column]
    private ?int $seatNumber = null;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: OpenHour::class)]
    private Collection $openHours;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'Relation', targetEntity: Dish::class)]
    private Collection $dishes;

    public function __construct()
    {
        $this->openHours = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->dishes = new ArrayCollection();
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    /**
     * @return Collection<int, OpenHour>
     */
    public function getOpenHours(): Collection
    {
        return $this->openHours;
    }

    public function addOpenHour(OpenHour $openHour): self
    {
        if (!$this->openHours->contains($openHour)) {
            $this->openHours->add($openHour);
            $openHour->setRelation($this);
        }

        return $this;
    }

    public function removeOpenHour(OpenHour $openHour): self
    {
        if ($this->openHours->removeElement($openHour)) {
            // set the owning side to null (unless already changed)
            if ($openHour->getRelation() === $this) {
                $openHour->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setRelation($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRelation() === $this) {
                $image->setRelation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dish>
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes->add($dish);
            $dish->setRelation($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->removeElement($dish)) {
            // set the owning side to null (unless already changed)
            if ($dish->getRelation() === $this) {
                $dish->setRelation(null);
            }
        }

        return $this;
    }
}
