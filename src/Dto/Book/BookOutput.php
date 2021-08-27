<?php

declare(strict_types=1);

namespace App\Dto\Book;

use App\Attribute\DTOOutputGroups;
use App\Dto\Resource\Output;
use App\Entity\Book\AuthorInterface;
use DateTimeInterface;

#[DTOOutputGroups([self::DTO_GROUP_BOOK_READ])]
class BookOutput extends Output
{

    public const DTO_GROUP_BOOK_READ = 'book:dto:read';

    public ?AuthorInterface $author = null;

    public ?string $title = null;

    public ?string $description = null;

    public ?DateTimeInterface $publicationDate = null;

}
