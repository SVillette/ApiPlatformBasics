<?php

declare(strict_types=1);

namespace App\Core\PropertyProvider;

use Doctrine\Common\Util\ClassUtils;
use Symfony\Component\PropertyInfo\PropertyListExtractorInterface;

class SerializedPropertiesProvider implements SerializedPropertiesProviderInterface
{

    private PropertyListExtractorInterface $serializerExtractor;

    public function __construct(PropertyListExtractorInterface $serializerExtractor)
    {
        $this->serializerExtractor = $serializerExtractor;
    }

    public function getProperties(object $object, array $groups = []): array
    {
        return $this->getPropertiesByClass(ClassUtils::getClass($object), $groups);
    }

    public function getPropertiesByClass(string $className, array $groups = []): array
    {
        return $this->serializerExtractor->getProperties($className, ['serializer_groups' => $groups]);
    }

}
