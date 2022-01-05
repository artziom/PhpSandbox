<?php

namespace App\Serializer\Normalizer;

use App\Dto\CheeseListingInput;
use App\Entity\CheeseListing;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CheeseListingInputDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    private ObjectNormalizer $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $context[AbstractNormalizer::OBJECT_TO_POPULATE] = $this->createDto($context);

        return $this->objectNormalizer->denormalize($data, $type, $format, $context);
    }

    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $type === CheeseListingInput::class;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return true;
    }

    private function createDto(array $context): CheeseListingInput
    {
        $entity = $context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? null;
        $dto = new CheeseListingInput();
        // not an edit, so just return an empty DTO
        if (!$entity) {
            return $dto;
        }
        if (!$entity instanceof CheeseListing) {
            throw new \Exception(sprintf('Unexpected resource class "%s"', get_class($entity)));
        }
        $dto->title = $entity->getTitle();
        $dto->price = $entity->getPrice();
        $dto->description = $entity->getDescription();
        $dto->owner = $entity->getOwner();
        $dto->isPublished = $entity->getIsPublished();
        return $dto;
    }
}