<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Carbon\Carbon;
use DateTimeImmutable;
use App\Repository\CheeseListingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=CheeseListingRepository::class)
 */
#[ApiResource(
    collectionOperations: array("get", "post"),
    itemOperations: array("get", "put", "delete", "patch"),
    shortName: "cheeses",
    denormalizationContext: array("groups" => array("cheese_listing:write"), "swagger_definition_name" => "Write"),
    normalizationContext: array("groups" => array("cheese_listing:read"), "swagger_definition_name" => "Read")
)]
class CheeseListing
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(array("cheese_listing:read", "cheese_listing:write"))]
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    #[Groups(array("cheese_listing:read"))]
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(array("cheese_listing:read", "cheese_listing:write"))]
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = false;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    public function __construct(string $title = null)
    {
        $this->createdAt = new DateTimeImmutable();
        $this->title = $title;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * The description of the cheese as raw text
     */
    #[Groups(array("cheese_listing:write"))]
    #[SerializedName("description")]
    public function setTextDescription(string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * How long ago in text that this cheese listing was added.
     */
    #[Groups(array("cheese_listing:read"))]
    public function getCreatedAtAgo(): string
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }
}
