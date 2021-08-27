<?php

declare(strict_types=1);

namespace App\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Attribute\DTOGroupsProviderInterface;
use App\Core\PropertyProvider\SerializedPropertiesProviderInterface;
use App\Dto\Resource\Input;
use App\Entity\Resource\ResourceInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

final class InputDataTransformer extends AbstractDataTransformer implements DataTransformerInterface
{

    private DTOGroupsProviderInterface $groupsProvider;

    private PropertyAccessor $propertyAccessor;

    private SerializedPropertiesProviderInterface $serializedPropertiesProvider;

    public function __construct(
        DTOGroupsProviderInterface $DTOGroupsProvider,
        SerializedPropertiesProviderInterface $serializedPropertiesProvider
    ) {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->serializedPropertiesProvider = $serializedPropertiesProvider;
        $this->groupsProvider = $DTOGroupsProvider;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Input) {
            self::throwUnprocessableObjectException($object, Input::class);
        }

        $resource = $context[AbstractNormalizer::OBJECT_TO_POPULATE] ?? null;

        $groups = $this->groupsProvider->getGroups($object);

        if (null === $resource) {
            $resource = new $to();
        }

        $properties = $this->serializedPropertiesProvider->getProperties($resource, $groups);

        foreach ($properties as $property) {
            $propertyValue = $this->propertyAccessor->getValue($object, $property);

            $this->propertyAccessor->setValue($resource, $property, $propertyValue);
        }

        return $resource;
    }

    /**
     * @throws ReflectionException
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        if ($data instanceof ResourceInterface) {
            return false;
        }

        $targetReflection = new ReflectionClass($to);

        return
            $targetReflection->isSubclassOf(ResourceInterface::class) &&
            null !== ($context['input']['class'] ?? null)
        ;
    }

}
