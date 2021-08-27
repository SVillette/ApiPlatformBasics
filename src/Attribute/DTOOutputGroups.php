<?php

declare(strict_types=1);

namespace App\Attribute;

use App\Dto\Resource\Output;
use Attribute;
use JetBrains\PhpStorm\Pure;

#[Attribute]
final class DTOOutputGroups extends DTOGroups
{

    #[Pure]
    public function __construct(array $groups = [])
    {
        parent::__construct($groups);

        if (empty($this->groups)) {
            $this->groups = [Output::GROUP_DTO_READ];
        }
    }

}
