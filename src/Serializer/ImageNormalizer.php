<?php

namespace App\Serializer;

use App\Entity\Episode;
use App\Entity\Movie;
use App\Entity\Serie;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class ImageNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'IMAGE_NORMALIZER_ALREADY_CALLED';

    protected $baseUrl;

    public function __construct(private StorageInterface $storage, RequestStack $requestStack)
    {
        $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
    }

    public function normalize($object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        $context[self::ALREADY_CALLED] = true;

        if(!empty($object->getImage()) && !str_starts_with($object->getImage(), 'http')) {
            $object->setImage($this->baseUrl . $this->storage->resolveUri($object, 'imageFile'));
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }
        
        return ($data instanceof Movie || $data instanceof Serie || $data instanceof Episode) ;
    }
}