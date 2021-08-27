<?php

declare(strict_types=1);

namespace App\Entity\Book;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\Book\BookOutput;
use App\Dto\Book\CreateBook;
use App\Dto\Book\UpdateBook;
use App\Entity\Resource\ResourceTrait;
use App\Entity\Resource\TimestampableTrait;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations: [
        "get" => [],
        "post" => [
            "method" => Request::METHOD_POST,
            "input" => CreateBook::class,
            "denormalizationContext" => [
                "groups" => [CreateBook::DTO_GROUP_BOOK_CREATE]
            ]
        ]
    ],
    itemOperations: [
        "get" => [],
        "update" => [
            "method" => Request::METHOD_PUT,
            "input" => UpdateBook::class,
            "denormalizationContext" => [
                "groups" => [UpdateBook::DTO_GROUP_BOOK_UPDATE]
            ]
        ],
        "patch" => [
            "method" => Request::METHOD_PATCH,
            "input" => UpdateBook::class,
            "denormalizationContext" => [
                "groups" => [UpdateBook::DTO_GROUP_BOOK_UPDATE]
            ]
        ],
        "delete" => []
    ],
    normalizationContext: [
        "groups" => [BookOutput::DTO_GROUP_BOOK_READ]
    ],
    output: BookOutput::class
)]
#[Entity]
#[Table(name: "book")]
class Book implements BookInterface
{

    use ResourceTrait, TimestampableTrait;

    #[Column(type: Types::STRING, nullable: false)]
    #[Groups([BookOutput::DTO_GROUP_BOOK_READ, CreateBook::DTO_GROUP_BOOK_CREATE])]
    private ?string $title = null;

    #[Column(type: Types::TEXT, nullable: false)]
    #[Groups([BookOutput::DTO_GROUP_BOOK_READ, CreateBook::DTO_GROUP_BOOK_CREATE])]
    private ?string $description = null;

    #[ManyToOne(targetEntity: Author::class, cascade: ["persist"], inversedBy: "books")]
    #[JoinColumn(name: "author_id", referencedColumnName: "id", nullable: false)]
    #[Groups([BookOutput::DTO_GROUP_BOOK_READ, CreateBook::DTO_GROUP_BOOK_CREATE])]
    private ?AuthorInterface $author = null;

    #[Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Groups([CreateBook::DTO_GROUP_BOOK_CREATE])]
    private ?DateTimeInterface $publicationDate = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getAuthor(): ?AuthorInterface
    {
        return $this->author;
    }

    public function setAuthor(?AuthorInterface $author): void
    {
        $this->author = $author;
    }

    public function getPublicationDate(): ?DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(?DateTimeInterface $publicationDate): void
    {
        $this->publicationDate = $publicationDate;
    }

}
