<?php

declare(strict_types=1);

namespace App\Entity\Book;

use App\Entity\Resource\ResourceInterface;
use App\Entity\Resource\TimestampableInterface;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;

interface AuthorInterface extends ResourceInterface, TimestampableInterface
{

    public function getFirstName(): ?string;

    public function setFirstName(?string $firstName): void;

    public function getLastName(): ?string;

    public function setLastName(?string $lastName): void;

    public function getBirthday(): ?DateTimeInterface;

    public function setBirthday(?DateTimeInterface $birthday): void;

    public function hasBooks(): bool;

    /**
     * @return Collection<int, BookInterface>
     */
    public function getBooks(): Collection;

    public function hasBook(?BookInterface $book): bool;

    public function addBook(?BookInterface $book): void;

    public function removeBook(?BookInterface $book): void;

}
