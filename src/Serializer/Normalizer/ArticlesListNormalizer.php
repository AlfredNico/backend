<?php

declare(strict_types=1);

namespace App\Serializer\Normalizer;

use App\Entity\Article;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ArticlesListNormalizer implements NormalizerInterface
{

    private $objectNormalizer;

    public function __construct(ObjectNormalizer $objectNormalizer)
    {
        $this->objectNormalizer = $objectNormalizer;
    }

    public function normalize($object, ?string $format = null, array $context = [])
    {
        $context['ignored_attributes'] = ['user', 'createdAt', 'updatedAt'];

        $object->getImageURL(
            'http://127.0.0.1:8000/' . $object->getImageURL()
        );

        return $this->objectNormalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null)
    {
        return $data instanceof Article;
    }
}
