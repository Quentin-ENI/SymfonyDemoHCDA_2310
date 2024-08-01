<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => ['getCourse']]),
        new GetCollection(normalizationContext: ['groups' => ['getCourses']]),
        new Post(denormalizationContext: ['groups' => ['postCourse']]),
        new Put(),
        new Patch(),
        new Delete()
    ],
)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['getCourses', 'getCourse'])]
    private ?int $id = null;

    #[ORM\Column(name: 'label', length: 255)]
    #[Assert\NotBlank(message: 'Ce champ doit être rempli')]
    #[Assert\Length(min: 3, max: 255,
        minMessage: 'Le nom du cours doit contenir au moins 3 caractères',
        maxMessage: 'Le nom du cours ne doit pas contenir plus de 255 caractères')
    ]
    #[Groups(['getCourses', 'getCourse', 'postCourse'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['getCourses', 'getCourse'])]
    private ?string $content = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\NotBlank(message: 'La durée du cours doit être rempli')]
    #[Assert\Positive(message: 'La durée du cours doit être un entier positif')]
    #[Groups(['getCourses', 'getCourse'])]
    private ?int $duration = null;

    #[ORM\Column]
    #[Groups(['getCourses', 'getCourse'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['getCourses', 'getCourse'])]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(options: ['default' => false])]
    #[Groups(['getCourse'])]
    private ?bool $published = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['getCourse'])]
    private ?string $thumbnail = null;

    #[Vich\UploadableField(mapping: 'courses', fileNameProperty: 'thumbnail')]
    #[Assert\File(mimeTypes: ['image/jpeg', 'image/png'])]
    private ?File $thumbnailFile = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'courses')]
    #[Groups(['getCourse'])]
    private Collection $categories;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->published = false;
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): static
    {
        $this->published = $published;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): static
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getThumbnailFile(): ?File
    {
        return $this->thumbnailFile;
    }

    public function setThumbnailFile(?File $thumbnailFile): static
    {
        $this->thumbnailFile = $thumbnailFile;
        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
