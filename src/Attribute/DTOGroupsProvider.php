<?php

declare(strict_types=1);

namespace App\Attribute;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ReflectionAttribute;
use ReflectionClass;

class DTOGroupsProvider implements DTOGroupsProviderInterface
{

    public function getGroups(object $object): array
    {
        $groups = new ArrayCollection();

        $reflection = new ReflectionClass($object);

        $attributes = $reflection->getAttributes();

        foreach ($attributes as $attributeReflection) {
            $attributeGroups = $this->getGroupsByReflectionAttribute($attributeReflection);

            $this->addAttributeGroups($groups, $attributeGroups);
        }

        return $groups->toArray();
    }

    public function getGroupsByReflection(ReflectionClass $reflection): array
    {
        $groups = new ArrayCollection();

        foreach ($reflection->getAttributes() as $attribute) {
            $attributeGroups = $this->getGroupsByReflectionAttribute($attribute);

            $this->addAttributeGroups($groups, $attributeGroups);
        }

        return $groups->toArray();
    }

    private function getGroupsByReflectionAttribute(ReflectionAttribute $reflectionAttribute): array
    {
        $groups = [];

        $attribute = $reflectionAttribute->newInstance();

        if (!$attribute instanceof DTOGroups) {
            return [];
        }

        foreach ($attribute->groups as $group) {
            if (in_array($group, $groups)) {
                continue;
            }

            $groups[] = $group;
        }

        return $groups;
    }

    private function addAttributeGroups(Collection $groups, array $attributeGroups): void
    {
        foreach ($attributeGroups as $attributeGroup) {
            if ($groups->contains($attributeGroup)) {
                continue;
            }

            $groups->add($attributeGroup);
        }
    }

}
