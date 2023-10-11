<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\MovieRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Doctrine\Orm\Filter\{SearchFilter, OrderFilter};
use App\Filter\PubliedFilter;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new GetCollection()
    ],
    normalizationContext: ['groups' => 'movies:collection']
)]
class Movie
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
    #[Groups("movies:collection")]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    #[Groups("movies:collection")]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups("movies:collection")]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups("movies:collection")]
    private ?int $age_restriction = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    #[Groups("movies:collection")]
    #[ApiFilter(PubliedFilter::class)]
    #[ApiFilter(OrderFilter::class, properties: ['publication_date' => 'DESC'])]
    private ?\DateTimeInterface $publication_date = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'movies')]
    #[Groups("movies:collection")]
    #[ApiFilter(SearchFilter::class, properties: ['categories.id' => 'exact'])]
    private Collection $categories;

    #[Vich\UploadableField(mapping: 'movies_images', fileNameProperty: 'image')]
    #[Assert\Image(
        mimeTypes:['image/png'],
        detectCorrupted:true
    )]
    private ?File $imageFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups("movies:collection")]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'movies_videos', fileNameProperty: 'video')]
    #[Assert\File(
        mimeTypes:['video/*']
    )]
    private ?File $videoFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->publication_date = new DateTime();
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

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publication_date;
    }

    public function setPublicationDate(\DateTimeInterface $publication_date): self
    {
        $this->publication_date = $publication_date;

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

    /**
     * Get the value of slug
     *
     * @return ?string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Set the value of slug
     *
     * @param ?string $slug
     *
     * @return self
     */
    public function setSlug(?string $slug): self
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
     * Get the value of video
     *
     * @return ?string
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * Set the value of video
     *
     * @param ?string $video
     *
     * @return self
     */
    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get the value of videoFile
     *
     * @return ?File
     */
    public function getVideoFile(): ?File
    {
        return $this->videoFile;
    }

    /**
     * Set the value of videoFile
     *
     * @param ?File $videoFile
     *
     * @return self
     */
    public function setVideoFile(?File $videoFile = null): self
    {
        $this->videoFile = $videoFile;

        if (null !== $videoFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }
}
