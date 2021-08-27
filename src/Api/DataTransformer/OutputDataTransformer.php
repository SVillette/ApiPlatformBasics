<?php

declare(strict_types=1);

namespace App\Api\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Attribute\DTOGroupsProviderInterface;
use App\Core\PropertyProvider\SerializedPropertiesProviderInterface;
use App\Dto\Resource\Output;
use App\Entity\Resource\ResourceInterface;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

final class OutputDataTransformer extends AbstractDataTransformer implements DataTransformerInterface
{

    private DTOGroupsProviderInterface $groupsProvider;

    private PropertyAccessor $propertyAccessor;

    private SerializedPropertiesProviderInterface $serializedPropertiesProvider;

    public function __construct(
        DTOGroupsProviderInterface $DTOGroupsProvider,
        SerializedPropertiesProviderInterface $serializedPropertiesProvider
    ) {
        $this->groupsProvider = $DTOGroupsProvider;
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->serializedPropertiesProvider = $serializedPropertiesProvider;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof ResourceInterface) {
            self::throwUnprocessableObjectException($object, ResourceInterface::class);
        }

        $resourceOutput = new $to();
        $groups = $this->groupsProvider->getGroups($resourceOutput);

        $properties = $this->serializedPropertiesProvider->getProperties($object, $groups);

        foreach ($properties as $property) {
            $propertyValue = $this->propertyAccessor->getValue($object, $property);

            $this->propertyAccessor->setValue($resourceOutput, $property, $propertyValue);
        }

        return $resourceOutput;
    }

    /**
     * @throws ReflectionException
     */
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        $targetReflection = new ReflectionClass($to);

        return $targetReflection->isSubclassOf(Output::class) && $data instanceof ResourceInterface;
    }

}
