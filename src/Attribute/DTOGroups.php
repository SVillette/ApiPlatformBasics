<?php

declare(strict_types=1);

namespace App\Attribute;

abstract class DTOGroups
{

    protected function __construct(
        public array $groups = []
    ) {
    }

}
