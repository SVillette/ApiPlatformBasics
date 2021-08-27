<?php

declare(strict_types=1);

namespace App\Attribute;

use App\Dto\Resource\Input;
use Attribute;
use JetBrains\PhpStorm\Pure;

#[Attribute]
final class DTOInputGroups extends DTOGroups
{

    #[Pure]
    public function __construct(array $groups = [])
    {
        parent::__construct($groups);

        if (empty($this->groups)) {
            $this->groups = [Input::GROUP_DTO_CREATE, Input::GROUP_DTO_UPDATE];
        }
    }

}
