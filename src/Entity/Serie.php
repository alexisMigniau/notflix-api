<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new GetCollection()
    ],
    normalizationContext: ['groups' => 'series:collection']
)]
class Serie
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ApiProperty(identifier: false)]
    #[ORM\Column]
    private ?int $id = null;
    
    #[Gedmo\Slug(fields: ['name'])]
    #[ApiProperty(identifier: true)]
    #[ORM\Column(type : "string", length : 128, unique : true)]
    #[Groups("series:collection")]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Groups("series:collection")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("series:collection")]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups("series:collection")]
    private ?int $age_restriction = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'series')]
    #[Groups("series:collection")]
    #[ApiFilter(SearchFilter::class, properties: ['categories.id' => 'exact'])]
    private Collection $categories;

    #[Vich\UploadableField(mapping: 'movies_images', fileNameProperty: 'image')]
    #[Assert\Image(
        mimeTypes:['image/png'],
        detectCorrupted:true
    )]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("series:collection")]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'Serie', targetEntity: Season::class, orphanRemoval: true)]
    private Collection $seasons;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->seasons = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAgeRestriction(): ?int
    {
        return $this->age_restriction;
    }

    public function setAgeRestriction(?int $age_restriction): self
    {
        $this->age_restriction = $age_restriction;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get the value of image
     *
     * @return ?string
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @param ?string $image
     *
     * @return self
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of imageFile
     *
     * @return ?File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param ?File $imageFile
     *
     * @return self
     */
    public function setImageFile(?File $imageFile = null): self
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return Collection<int, Season>
     */
    public function getSeasons(): Collection
    {
        return $this->seasons;
    }

    public function addSeason(Season $season): static
    {
        if (!$this->seasons->contains($season)) {
            $this->seasons->add($season);
            $season->setSerie($this);
        }

        return $this;
    }

    public function removeSeason(Season $season): static
    {
        if ($this->seasons->removeElement($season)) {
            // set the owning side to null (unless already changed)
            if ($season->getSerie() === $this) {
                $season->setSerie(null);
            }
        }

        return $this;
    }
}
