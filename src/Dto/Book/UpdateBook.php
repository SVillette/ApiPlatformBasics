<?php

declare(strict_types=1);

namespace App\Dto\Book;

use App\Attribute\DTOOutputGroups;
use App\Dto\Resource\Input;

#[DTOOutputGroups([self::DTO_GROUP_BOOK_UPDATE])]
class UpdateBook extends Input
{

    public const DTO_GROUP_BOOK_UPDATE = 'book:dto:update';

    public ?string $description = null;

}
