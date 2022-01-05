<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\CheeseListingInput;
use App\Entity\CheeseListing;

class CheeseListingInputDataTransformer implements DataTransformerInterface
{
    /**
     * @param CheeseListingInput $input
     */
    public function transform($input, string $to, array $context = [])
    {
        $cheeseListing = new CheeseListing($input->title);
        $cheeseListing->setDescription($input->description);
        $cheeseListing->setPrice($input->price);
        $cheeseListing->setOwner($input->owner);
        $cheeseListing->setIsPublished($input->isPublished);

        return $cheeseListing;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if($data instanceof CheeseListing){
            return false;
        }

        return $to === CheeseListing::class && ($context['input']['class'] ?? null) === CheeseListingInput::class;
    }

}