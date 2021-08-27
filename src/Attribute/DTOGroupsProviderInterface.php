<?php

declare(strict_types=1);

namespace App\Attribute;

use ReflectionClass;

interface DTOGroupsProviderInterface
{

    public function getGroups(object $object): array;

    public function getGroupsByReflection(ReflectionClass $reflection): array;

}
