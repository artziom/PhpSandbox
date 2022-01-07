<?php

namespace App\Dto;

use App\Entity\CheeseListing;
use App\Entity\User;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

class CheeseListingInput
{
    /**
     * @var string
     *
     * @Groups({"cheese:write", "user:write"})
     */
    public $title;

    /**
     * @var int
     *
     * @Groups({"cheese:write", "user:write"})
     */
    public $price;

    /**
     * @var User
     * @Groups({"cheese:collection:post"})
     */
    public $owner;

    /**
     * @Groups({"cheese:write"})
     */
    public bool $isPublished = false;

    /** @var string */
    public $description;

    public static function createFromEntity(?CheeseListing $cheeseListing): self
    {
        $dto = new CheeseListingInput();
        // not an edit, so just return an empty DTO
        if (!$cheeseListing) {
            return $dto;
        }

        $dto->title = $cheeseListing->getTitle();
        $dto->price = $cheeseListing->getPrice();
        $dto->description = $cheeseListing->getDescription();
        $dto->owner = $cheeseListing->getOwner();
        $dto->isPublished = $cheeseListing->getIsPublished();

        return $dto;
    }

    public function createOrUpdateEntity(?CheeseListing $cheeseListing): CheeseListing
    {
        if (!$cheeseListing) {
            $cheeseListing = new CheeseListing((string) $this->title);
        }

        $cheeseListing->setDescription((string) $this->description);
        $cheeseListing->setPrice((int) $this->price);
        $cheeseListing->setOwner($this->owner);
        $cheeseListing->setIsPublished($this->isPublished);

        return $cheeseListing;
    }

    /**
     * The description of the cheese as raw text.
     *
     * @Groups({"cheese:write", "user:write"})
     * @SerializedName("description")
     */
    public function setTextDescription(string $description): self
    {
        $this->description = nl2br($description);

        return $this;
    }
}