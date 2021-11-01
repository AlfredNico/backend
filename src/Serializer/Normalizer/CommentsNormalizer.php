<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Comment;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CommentsNormalizer implements NormalizerInterface
{

    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function normalize($object, ?string $format = null, array $context = [])
    {
        $context['ignored_attributes'] = ['article'];

        return $this->objectNormalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null)
    {
        return $data instanceof Comment;
    }
}
