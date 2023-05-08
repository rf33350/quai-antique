<?php

namespace App\Entity;

use App\Repository\DishRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation\Uploadable;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints as Assert;

#[Uploadable]
#[ORM\Entity(repositoryClass: DishRepository::class)]
class Dish
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $Category = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[UploadableField(mapping: 'dish_images', fileNameProperty: "ImagePath")]
    private ?File $ImageFile = null;


    #[ORM\Column(length: 255)]
    #[Assert\File(maxSize: "2M", mimeTypes: ["image/jpeg", "image/png", "image/gif", "image/jpg"])]
    private ?string $ImagePath = null;

    #[ORM\Column]
    private ?float $Price = null;

    #[ORM\ManyToOne(inversedBy: 'dishes')]
    private ?Restaurant $Relation = null;

    #[ORM\Column]
    private ?bool $isStar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(string $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->ImagePath;
    }

    public function setImagePath(string $ImagePath): void
    {
        $this->ImagePath = $ImagePath;

    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getRelation(): ?Restaurant
    {
        return $this->Relation;
    }

    public function setRelation(?Restaurant $Relation): self
    {
        $this->Relation = $Relation;

        return $this;
    }

    public function isIsStar(): ?bool
    {
        return $this->isStar;
    }

    public function setIsStar(bool $isStar): self
    {
        $this->isStar = $isStar;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->ImageFile;
    }

    public function setImageFile(File $ImageFile = null)
    {
        $this->ImageFile = $ImageFile;

    }
}
