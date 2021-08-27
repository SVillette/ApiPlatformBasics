<?php

declare(strict_types=1);

namespace App\Api\Normalizer;

use App\Attribute\DTOGroupsProviderInterface;
use App\Dto\Resource\Output;
use InvalidArgumentException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class OutputAttributeNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{

    private const ALREADY_CALLED = 'RESOURCE_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';

    private ClassMetadataFactoryInterface $classMetadataFactory;

    private DTOGroupsProviderInterface $groupsProvider;

    private NormalizerInterface $normalizer;

    public function __construct(
        ClassMetadataFactoryInterface $classMetadataFactory,
        DTOGroupsProviderInterface $DTOGroupsProvider
    ) {
        $this->classMetadataFactory = $classMetadataFactory;
        $this->groupsProvider = $DTOGroupsProvider;
    }

    public function setNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /** @noinspection PhpMissingReturnTypeInspection */
    public function normalize($object, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;

        if (!$object instanceof Output) {
            throw new InvalidArgumentException(sprintf(
                'Expected object to normalize of type %s got %s',
                Output::class,
                get_class($object)
            ));
        }

        $dtoMetadata = $this->classMetadataFactory->getMetadataFor($object);

        $groups = $this->groupsProvider->getGroupsByReflection($dtoMetadata->getReflectionClass());

        foreach ($dtoMetadata->getAttributesMetadata() as $metadataAttribute) {
            foreach ($groups as $group) {
                $metadataAttribute->addGroup($group);
            }
        }

        return $this->normalizer->normalize($object, $format, $context);
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED]) && $context[self::ALREADY_CALLED]) {
            return false;
        }

        return $data instanceof Output;
    }

}
