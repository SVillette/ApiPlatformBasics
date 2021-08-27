<?php

declare(strict_types=1);

namespace App\Core\PropertyProvider;

interface SerializedPropertiesProviderInterface
{

    public function getProperties(object $object, array $groups = []): array;

    public function getPropertiesByClass(string $className, array $groups = []): array;

}
