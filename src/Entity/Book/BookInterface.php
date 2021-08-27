<?php

declare(strict_types=1);

namespace App\Entity\Book;

use App\Entity\Resource\ResourceInterface;
use App\Entity\Resource\TimestampableInterface;
use DateTimeInterface;

interface BookInterface extends ResourceInterface, TimestampableInterface
{

    public function getTitle(): ?string;

    public function setTitle(?string $title): void;

    public function getDescription(): ?string;

    public function setDescription(?string $description): void;

    public function getAuthor(): ?AuthorInterface;

    public function setAuthor(?AuthorInterface $author): void;

    public function getPublicationDate(): ?DateTimeInterface;

    public function setPublicationDate(?DateTimeInterface $publicationDate): void;

}
