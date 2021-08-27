<?php

declare(strict_types=1);

namespace App\Dto\Book;

use App\Attribute\DTOInputGroups;
use App\Dto\Resource\Input;
use App\Entity\Book\AuthorInterface;
use DateTimeInterface;

#[DTOInputGroups([self::DTO_GROUP_BOOK_CREATE])]
class CreateBook extends Input
{

    public const DTO_GROUP_BOOK_CREATE = 'book:dto:create';

    public ?AuthorInterface $author = null;

    public ?string $title = null;

    public ?string $description = null;

    public ?DateTimeInterface $publicationDate = null;

}
