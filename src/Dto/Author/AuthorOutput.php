<?php

declare(strict_types=1);

namespace App\Dto\Author;

use App\Attribute\DTOOutputGroups;
use App\Dto\Book\BookOutput;
use App\Dto\Resource\Output;
use DateTimeInterface;

#[DTOOutputGroups([BookOutput::DTO_GROUP_BOOK_READ])]
class AuthorOutput extends Output
{

    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?DateTimeInterface $birthday = null;

}
